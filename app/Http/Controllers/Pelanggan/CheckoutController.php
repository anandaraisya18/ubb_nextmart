<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use App\Models\ManagementGroup;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use RuntimeException;

class CheckoutController extends Controller
{
    public function index()
    {
        $items = $this->items();

        if ($redirect = $this->guard($items)) {
            return $redirect;
        }

        return view('pelanggan.checkout.index', [
            'items'    => $items,
            'group'    => $items->first()['nama_group'],
            'subtotal' => $items->sum('subtotal'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'           => ['required', 'string', 'max:100'],
            'telepon'        => ['required', 'string', 'regex:/^[0-9+\-\s]{8,20}$/'],
            'email'          => ['required', 'email', 'max:100'],
            'catatan'        => ['nullable', 'string', 'max:500'],
            'payment_method' => ['required', 'in:qris'],
        ], [
            'nama.required'    => 'Nama lengkap wajib diisi.',
            'telepon.required' => 'Nomor HP wajib diisi.',
            'telepon.regex'    => 'Format nomor HP tidak valid.',
            'email.required'   => 'Email wajib diisi.',
            'email.email'      => 'Format email tidak valid.',
        ]);

        $items = $this->items();

        if ($redirect = $this->guard($items)) {
            return $redirect;
        }

        try {
            $order = DB::transaction(function () use ($data, $items) {
                // Kunci baris produk agar stok tidak diperebutkan pesanan lain.
                $produk = Produk::whereIn('id_produk', $items->pluck('id_produk'))
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id_produk');

                $subtotal = 0;
                $lines = [];

                foreach ($items as $item) {
                    $p = $produk->get($item['id_produk']);

                    if (! $p || $p->status !== 'aktif' || (int) $p->stok < $item['jumlah']) {
                        throw new RuntimeException(
                            'Stok "' . $item['nama'] . '" tidak mencukupi. Silakan sesuaikan jumlahnya.'
                        );
                    }

                    $harga = (int) round($p->harga);

                    $lines[] = [
                        'id_produk' => $p->id_produk,
                        'jumlah'    => $item['jumlah'],
                        'harga'     => $harga,
                        'subtotal'  => $harga * $item['jumlah'],
                    ];

                    $subtotal += $harga * $item['jumlah'];
                }

                $pelanggan = $this->savePelanggan($data);

                $attrs = [
                    'no_resi'           => $this->generateResi(),
                    'tipe_transaksi'    => 'online',
                    'jenis_pengambilan' => 'ambil_di_tempat',
                    'tanggal_pesanan'   => now(),
                    'subtotal'          => $subtotal,
                    'total'              => $subtotal,
                    'status_pesanan'     => 'menunggu_pembayaran',
                    'id_pelanggan'       => $pelanggan->getKey(),
                ];

                if (Schema::hasColumn('pesanan', 'catatan')) {
                    $attrs['catatan'] = $data['catatan'] ?? null;
                }

                $order = new Pesanan();
                $order->forceFill($attrs)->save();

                foreach ($lines as $line) {
                    (new DetailPesanan())->forceFill($line + [
                        'id_pesanan' => $order->getKey(),
                    ])->save();

                    Produk::where('id_produk', $line['id_produk'])
                        ->decrement('stok', $line['jumlah']);
                }

                return $order;
            });
        } catch (RuntimeException $e) {
            return redirect()->route('pelanggan.keranjang.index')
                ->with('error', $e->getMessage());
        }

        // Keluarkan produk yang sudah dipesan dari keranjang.
        $cart = session('keranjang', []);

        foreach ($items as $item) {
            unset($cart[$item['id_produk']]);
        }

        session(['keranjang' => $cart]);
        session()->forget('checkout_items');
        session(['pesanan_terakhir' => $order->no_resi]);

        return redirect()->route('pelanggan.pembayaran')
            ->with('success', 'Pesanan ' . $order->no_resi . ' berhasil dibuat. Silakan lakukan pembayaran.');
    }

    /**
     * Cari pelanggan berdasarkan nomor HP atau email.
     * Gunakan pelanggan yang sudah ada agar tidak terjadi email duplikat.
     */
    private function savePelanggan(array $data): Pelanggan
    {
        $cols = Schema::getColumnListing('pelanggan');

        $pick = fn (array $candidates) => collect($candidates)
            ->first(fn ($c) => in_array($c, $cols, true));

        $kolomNama  = $pick(['nama_pelanggan', 'nama']);
        $kolomTelp  = $pick(['no_hp', 'telepon', 'no_telp', 'no_telepon']);
        $kolomEmail = $pick(['email']);

        $pelangganByTelp = $kolomTelp
            ? Pelanggan::where($kolomTelp, $data['telepon'])->first()
            : null;

        $pelangganByEmail = $kolomEmail
            ? Pelanggan::where($kolomEmail, $data['email'])->first()
            : null;

        // Jika nomor HP dan email mengarah ke dua pelanggan berbeda,
        // hentikan proses agar pesanan tidak masuk ke pelanggan yang salah.
        if (
            $pelangganByTelp &&
            $pelangganByEmail &&
            $pelangganByTelp->getKey() !== $pelangganByEmail->getKey()
        ) {
            throw new RuntimeException(
                'Nomor HP dan email terdaftar pada pelanggan berbeda. Periksa kembali data checkout.'
            );
        }

        $pelanggan = $pelangganByTelp ?? $pelangganByEmail;

        if ($pelanggan) {
            $attrs = [];

            if ($kolomNama) {
                $attrs[$kolomNama] = $data['nama'];
            }

            if ($kolomTelp && ! $pelangganByTelp) {
                $attrs[$kolomTelp] = $data['telepon'];
            }

            if ($kolomEmail && ! $pelangganByEmail) {
                $attrs[$kolomEmail] = $data['email'];
            }

            $pelanggan->forceFill($attrs)->save();

            return $pelanggan;
        }

        // Buat pelanggan baru hanya jika nomor HP dan email belum terdaftar.
        $attrs = [];

        if ($kolomNama) {
            $attrs[$kolomNama] = $data['nama'];
        }

        if ($kolomTelp) {
            $attrs[$kolomTelp] = $data['telepon'];
        }

        if ($kolomEmail) {
            $attrs[$kolomEmail] = $data['email'];
        }

        $pelanggan = new Pelanggan();
        $pelanggan->timestamps = Schema::hasColumn('pelanggan', 'created_at');
        $pelanggan->forceFill($attrs)->save();

        return $pelanggan;
    }

    /**
     * Baris checkout dari pilihan di keranjang.
     * Harga selalu diambil dari database.
     */
    private function items(): Collection
    {
        $pilihan = session('checkout_items', []);

        if (empty($pilihan)) {
            return collect();
        }

        $produk = Produk::aktif()
            ->with('toko')
            ->whereIn('id_produk', array_keys($pilihan))
            ->get();

        $namaGroup = ManagementGroup::whereIn(
            'id_group',
            $produk->map(fn ($p) => (int) ($p->toko->id_group ?? 0))
                ->unique()
                ->filter()
                ->values()
        )->pluck('nama_group', 'id_group');

        return $produk->map(function ($p) use ($pilihan, $namaGroup) {
            $idGroup = (int) ($p->toko->id_group ?? 0);
            $jumlah = (int) $pilihan[(int) $p->id_produk];
            $harga = (int) round($p->harga);

            return [
                'id_produk'  => (int) $p->id_produk,
                'nama'       => $p->nama_produk,
                'gambar'     => $p->gambar,
                'harga'      => $harga,
                'jumlah'     => $jumlah,
                'subtotal'   => $harga * $jumlah,
                'nama_toko'  => $p->toko->nama_toko ?? 'Toko',
                'id_group'   => $idGroup,
                'nama_group' => $namaGroup[$idGroup] ?? 'Tanpa Grup',
            ];
        })->values();
    }

    private function guard(Collection $items)
    {
        if ($items->isEmpty()) {
            return redirect()->route('pelanggan.keranjang.index')
                ->with('error', 'Pilih produk di keranjang terlebih dahulu.');
        }

        // Semua produk yang di-checkout harus dari satu grup.
        if ($items->pluck('id_group')->unique()->count() > 1) {
            return redirect()->route('pelanggan.keranjang.index')
                ->with('error', 'Produk dari grup berbeda tidak bisa di-checkout bersamaan.');
        }

        return null;
    }

    private function generateResi(): string
    {
        do {
            $resi = 'NXM-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));
        } while (Pesanan::where('no_resi', $resi)->exists());

        return $resi;
    }
}
