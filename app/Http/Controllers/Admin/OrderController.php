<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\DetailPesanan;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use RuntimeException;

class OrderController extends Controller
{
    public function dashboard()
    {
        $produkPerToko = DB::table('produk')
            ->select('id_toko', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('id_toko')
            ->pluck('jumlah', 'id_toko');

        $tokoList = DB::table('toko')->get()->map(function ($toko) use ($produkPerToko) {
            $toko->produk_count = $produkPerToko[$toko->id_toko] ?? 0;
            return $toko;
        });

        return view('admin.dashboard.index', [
            'totalProduk' => Produk::count(),

            'totalPesanan' => Pesanan::count(),

            'pesananDiproses' => Pesanan::where(
                'status_pesanan',
                'diproses'
            )->count(),

            'totalTransaksi' => Pesanan::where(
                'status_pesanan',
                'selesai'
            )->count(),

            'pesananTerbaru' => Pesanan::with('pelanggan')
                ->orderByDesc('tanggal_pesanan')
                ->limit(4)
                ->get(),

            'tokoList' => $tokoList,
        ]);
    }

    public function index(Request $request)
    {
        $validated = $request->validate([
            'q'      => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', Rule::in(array_keys(Pesanan::STATUS))],
        ]);

        $kolomNama = $this->kolomNamaPelanggan();

        $orders = Pesanan::with('pelanggan')
            ->when($validated['q'] ?? null, function ($query, $q) use ($kolomNama) {
                $q = str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $q);

                $query->where(function ($sub) use ($q, $kolomNama) {
                    $sub->where('no_resi', 'like', "%{$q}%")
                        ->orWhereHas('pelanggan', fn ($p) => $p->where($kolomNama, 'like', "%{$q}%"));
                });
            })
            ->when($validated['status'] ?? null, fn ($query, $s) => $query->where('status_pesanan', $s))
            ->orderByDesc('tanggal_pesanan')
            ->paginate(10)
            ->withQueryString();

        $counts = Pesanan::selectRaw('status_pesanan, COUNT(*) as jumlah')
            ->groupBy('status_pesanan')
            ->pluck('jumlah', 'status_pesanan');

        return view('admin.orders.index', [
            'orders' => $orders,
            'counts' => $counts,
            'total'  => $counts->sum(),
        ]);
    }

    public function create()
    {
        return view('admin.orders.create', [
            'produk' => Produk::where('status', 'aktif')
                ->orderBy('nama_produk')
                ->get(['id_produk', 'nama_produk', 'harga', 'stok']),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_pelanggan'    => ['required', 'string', 'max:100'],
            'no_resi'           => ['nullable', 'string', 'max:50', 'unique:pesanan,no_resi'],
            'tanggal_pesanan'   => ['required', 'date', 'before_or_equal:now'],
            'tipe_transaksi'    => ['required', Rule::in(array_keys(Pesanan::TIPE))],
            'jenis_pengambilan' => ['required', Rule::in(array_keys(Pesanan::PENGAMBILAN))],
            'total'             => ['required', 'integer', 'min:0'],
            'status_pesanan'    => [
                'required',
                Rule::in(array_diff(array_keys(Pesanan::STATUS), ['dibatalkan'])),
            ],
            'items'             => ['required', 'array', 'min:1'],
            'items.*.id_produk' => ['required', 'distinct', 'exists:produk,id_produk'],
            'items.*.jumlah'    => ['required', 'integer', 'min:1'],
        ], [
            'nama_pelanggan.required'    => 'Nama pelanggan wajib diisi.',
            'status_pesanan.in'          => 'Pesanan baru tidak bisa langsung berstatus dibatalkan.',
            'items.required'             => 'Tambahkan minimal satu produk.',
            'items.min'                  => 'Tambahkan minimal satu produk.',
            'items.*.id_produk.required' => 'Pilih produk pada setiap baris item.',
            'items.*.id_produk.distinct' => 'Produk yang sama tidak boleh dipilih dua kali.',
            'items.*.id_produk.exists'   => 'Produk tidak ditemukan.',
            'items.*.jumlah.min'         => 'Jumlah minimal 1.',
        ]);

        $namaPelanggan = trim($data['nama_pelanggan']);

        try {
            $order = DB::transaction(function () use ($data, $namaPelanggan) {
                $produk = Produk::whereIn(
                    'id_produk',
                    collect($data['items'])->pluck('id_produk')
                )
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id_produk');

                $lines = collect($data['items'])->map(function ($item) use ($produk) {
                    $p = $produk->get($item['id_produk']);
                    $jumlah = (int) $item['jumlah'];

                    if (! $p || (int) $p->stok < $jumlah) {
                        throw new RuntimeException(
                            'Stok "' . ($p->nama_produk ?? 'produk') . '" tidak mencukupi.'
                        );
                    }

                    $harga = (int) round($p->harga);

                    return [
                        'id_produk'   => $p->id_produk,
                        'nama_produk' => $p->nama_produk,
                        'jumlah'      => $jumlah,
                        'harga'       => $harga,
                        'subtotal'    => $harga * $jumlah,
                    ];
                });

                $pelanggan = $this->cariAtauBuatPelanggan($namaPelanggan);

                $orderData = collect($data)->except(['items', 'nama_pelanggan'])->all();
                $orderData['id_pelanggan'] = $pelanggan->getKey();
                $orderData['subtotal'] = $lines->sum('subtotal');
                $orderData['no_resi'] = $orderData['no_resi'] ?: $this->generateResi();

                $order = Pesanan::create($orderData);

                foreach ($lines as $line) {
                    (new DetailPesanan())->forceFill([
                        'id_pesanan' => $order->getKey(),
                        'id_produk'  => $line['id_produk'],
                        'jumlah'     => $line['jumlah'],
                        'harga'      => $line['harga'],
                        'subtotal'   => $line['subtotal'],
                    ])->save();

                    Produk::where('id_produk', $line['id_produk'])
                        ->decrement('stok', $line['jumlah']);
                }

                $this->writeAuditLog(
                    action: 'create',
                    order: $order,
                    description: 'Menambahkan pesanan: ' . $order->no_resi
                        . ' atas nama ' . $namaPelanggan
                        . ' (' . $lines->count() . ' produk)',
                    oldValues: null,
                    newValues: $this->snapshot($order) + [
                        'pelanggan' => $namaPelanggan,
                        'items' => $lines->map(fn ($l) => [
                            'produk'   => $l['nama_produk'],
                            'jumlah'   => $l['jumlah'],
                            'harga'    => $l['harga'],
                            'subtotal' => $l['subtotal'],
                        ])->all(),
                    ],
                );

                return $order;
            });
        } catch (RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        } catch (QueryException $e) {
            report($e);

            return back()->withInput()->with(
                'error',
                'Pesanan gagal disimpan karena data pelanggan atau pesanan tidak valid. Periksa kembali data yang dimasukkan.'
            );
        }

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Pesanan berhasil ditambahkan.');
    }

    public function show(Pesanan $order)
    {
        $order->load('pelanggan');

        return view('admin.orders.show', [
            'order' => $order,
            'items' => $this->items($order),
        ]);
    }

    public function edit(Pesanan $order)
    {
        $order->load('pelanggan');

        return view('admin.orders.edit', [
            'order' => $order,
            'items' => $this->items($order),
        ]);
    }

    public function update(Request $request, Pesanan $order)
    {
        $data = $request->validate([
            'status_pesanan' => ['required', Rule::in(array_keys(Pesanan::STATUS))],
        ]);

        if ($order->status_pesanan === 'dibatalkan' && $data['status_pesanan'] !== 'dibatalkan') {
            return back()->with('error', 'Pesanan yang sudah dibatalkan tidak dapat diaktifkan kembali.');
        }

        DB::transaction(function () use ($order, $data) {
            $oldStatus = $order->status_pesanan;
            $newStatus = $data['status_pesanan'];

            if ($newStatus === 'dibatalkan' && ! in_array($oldStatus, ['dibatalkan', 'selesai'], true)) {
                $order->batalkan();
            } else {
                $order->update($data);
            }

            $this->writeAuditLog(
                action: 'update',
                order: $order,
                description: 'Mengubah status pesanan ' . $order->no_resi
                    . ' dari ' . (Pesanan::STATUS[$oldStatus] ?? $oldStatus)
                    . ' ke ' . (Pesanan::STATUS[$order->status_pesanan] ?? $order->status_pesanan),
                oldValues: ['status_pesanan' => $oldStatus],
                newValues: ['status_pesanan' => $order->status_pesanan],
            );
        });

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function destroy(Pesanan $order)
    {
        try {
            DB::transaction(function () use ($order) {
                $snapshot = $this->snapshot($order);

                if (! in_array($order->status_pesanan, ['selesai', 'dibatalkan'], true)) {
                    $order->batalkan();
                }

                $this->writeAuditLog(
                    action: 'delete',
                    order: $order,
                    description: 'Menghapus pesanan: ' . $order->no_resi,
                    oldValues: $snapshot,
                    newValues: null,
                );

                $order->detail()->delete();
                $order->delete();
            });
        } catch (QueryException $e) {
            return back()->with('error', 'Pesanan tidak dapat dihapus karena masih memiliki data terkait.');
        }

        return redirect()->route('admin.orders.index')
            ->with('success', 'Pesanan berhasil dihapus.');
    }

    private function items(Pesanan $order)
    {
        if (! Schema::hasTable('detail_pesanan')) {
            return collect();
        }

        return $order->detail()->with('produk')->get();
    }

    private function kolomNamaPelanggan(): string
    {
        return Schema::hasColumn('pelanggan', 'nama_pelanggan')
            ? 'nama_pelanggan'
            : 'nama';
    }

    /**
     * Cari pelanggan berdasarkan nama.
     * Jika belum ada, buat pelanggan dengan email unik untuk transaksi offline.
     */
    private function cariAtauBuatPelanggan(string $nama): Pelanggan
    {
        $kolom = $this->kolomNamaPelanggan();

        $pelanggan = Pelanggan::where($kolom, $nama)->first();

        if ($pelanggan) {
            return $pelanggan;
        }

        $pelanggan = new Pelanggan();

        $pelanggan->timestamps = Schema::hasColumn('pelanggan', 'created_at');

        $data = [
            $kolom => $nama,
        ];

        if (Schema::hasColumn('pelanggan', 'email')) {
            $data['email'] = 'offline_' . Str::uuid() . '@nextmart.local';
        }

        if (Schema::hasColumn('pelanggan', 'no_hp')) {
            $data['no_hp'] = '-';
        }

        $pelanggan->forceFill($data)->save();

        return $pelanggan;
    }

    private function generateResi(): string
    {
        do {
            $resi = 'NXM-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));
        } while (Pesanan::where('no_resi', $resi)->exists());

        return $resi;
    }

    private function snapshot(Pesanan $order): array
    {
        return [
            'no_resi'           => $order->no_resi,
            'id_pelanggan'      => $order->id_pelanggan,
            'tipe_transaksi'    => $order->tipe_transaksi,
            'jenis_pengambilan' => $order->jenis_pengambilan,
            'tanggal_pesanan'   => optional($order->tanggal_pesanan)->toDateTimeString(),
            'subtotal'          => $order->subtotal,
            'total'             => $order->total,
            'status_pesanan'    => $order->status_pesanan,
        ];
    }

    private function writeAuditLog(
        string $action,
        Pesanan $order,
        string $description,
        ?array $oldValues = null,
        ?array $newValues = null,
    ): void {
        $actor = Auth::guard('admin')->user();

        AuditLog::create([
            'actor_type'  => 'admin',
            'actor_id'    => $actor?->getAuthIdentifier(),
            'actor_name'  => $actor?->nama
                ?? $actor?->name
                ?? 'Admin',
            'action'      => $action,
            'target_type' => 'Pesanan',
            'target_id'   => (string) $order->id_pesanan,
            'description' => $description,
            'old_values'  => $oldValues,
            'new_values'  => $newValues,
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
            'status'      => 'success',
        ]);
    }
}
