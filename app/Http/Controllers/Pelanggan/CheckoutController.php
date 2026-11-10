<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\DetailPesanan;
use App\Models\ManagementGroup;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Notifications\PesananAdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use RuntimeException;

class CheckoutController extends Controller
{
    public function index()
    {
        $items = $this->items();

        if ($redirect = $this->guard($items)) {
            return $redirect;
        }

        $namaGroup = $items->first()['nama_group'];

        return view('pelanggan.checkout.index', [
            'items'     => $items,
            'group'     => $namaGroup,
            'subtotal'  => $items->sum('subtotal'),
            'bisaAntar' => $this->bisaAntar($namaGroup),
        ]);
    }

    public function store(Request $request)
    {
        // Ambil akun pelanggan
        $pelanggan = Auth::guard('pelanggan')->user();

        if (! $pelanggan) {
            return redirect()->route('pelanggan.login');
        }

        $data = $request->validate([
            'catatan'           => ['nullable', 'string', 'max:500'],
            'payment_method'    => ['required', 'in:qris'],
            'jenis_pengambilan' => ['nullable', 'in:ambil_di_tempat,diantar'],
            'lokasi_antar'      => ['nullable', 'string', 'max:255'],
        ]);

        $items = $this->items();

        if ($redirect = $this->guard($items)) {
            return $redirect;
        }

        // Ambil ID grup dari item checkout
        $idGroup = (int) $items->first()['id_group'];

        // Pengantaran hanya untuk Neo Combi
        $bisaAntar = $this->bisaAntar(
            $items->first()['nama_group']
        );

        $diantar = $bisaAntar &&
            ($data['jenis_pengambilan'] ?? null) === 'diantar';

        $lokasi = trim($data['lokasi_antar'] ?? '');

        if ($diantar && $lokasi === '') {
            throw ValidationException::withMessages([
                'lokasi_antar' => 'Lokasi antar di lingkungan kampus wajib diisi.',
            ]);
        }

        $nomorHp = $pelanggan->no_hp ?? '';

        if ($diantar && $nomorHp === '') {
            throw ValidationException::withMessages([
                'lokasi_antar' => 'Nomor HP pada akun Anda belum tersedia. Silakan lengkapi profil terlebih dahulu.',
            ]);
        }

        try {
            $order = DB::transaction(function () use (
                $data,
                $items,
                $diantar,
                $lokasi,
                $pelanggan,
                $nomorHp
            ) {
                // Kunci hanya produk biasa (jasa cetak tidak memakai stok)
                $idProdukBiasa = $items->where('tipe', 'produk')->pluck('id_produk');

                $produk = $idProdukBiasa->isEmpty()
                    ? collect()
                    : Produk::whereIn('id_produk', $idProdukBiasa)
                        ->lockForUpdate()
                        ->get()
                        ->keyBy('id_produk');

                $subtotal = 0;
                $lines = [];

                foreach ($items as $item) {

                    // Job cetak: harga sudah dihitung server saat masuk keranjang
                    if ($item['tipe'] === 'cetak') {

                        if (! Storage::disk('local')->exists($item['cetak']['path_file'])) {
                            throw new RuntimeException(
                                'File "' . $item['cetak']['nama_file'] .
                                '" tidak ditemukan. Silakan hapus lalu upload ulang.'
                            );
                        }

                        $lines[] = [
                            'id_produk' => $item['id_produk'],
                            'jumlah'    => 1,
                            'harga'     => $item['harga'],
                            'subtotal'  => $item['harga'],
                            'meta'      => $item['cetak'],
                        ];

                        $subtotal += $item['harga'];

                        continue;
                    }

                    // Produk biasa
                    $p = $produk->get($item['id_produk']);

                    if (
                        ! $p ||
                        $p->status !== 'aktif' ||
                        (int) $p->stok < $item['jumlah']
                    ) {
                        throw new RuntimeException(
                            'Stok "' . $item['nama'] .
                            '" tidak mencukupi. Silakan sesuaikan jumlahnya.'
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

                // Data pesanan
                $attrs = [
                    'no_resi'           => $this->generateResi(),
                    'tipe_transaksi'    => 'online',
                    'jenis_pengambilan' => $diantar
                        ? 'diantar'
                        : 'ambil_di_tempat',
                    'tanggal_pesanan'   => now(),
                    'subtotal'          => $subtotal,
                    'total'             => $subtotal,
                    'status_pesanan'    => 'menunggu_pembayaran',
                    'id_pelanggan'      => $pelanggan->getKey(),
                ];

                if (Schema::hasColumn('pesanan', 'catatan')) {
                    $attrs['catatan'] = $data['catatan'] ?? null;
                }

                $order = new Pesanan();
                $order->forceFill($attrs)->save();

                // Simpan detail pesanan, detail cetak, dan kurangi stok
                foreach ($lines as $line) {
                    $meta = $line['meta'] ?? null;
                    unset($line['meta']);

                    $detail = new DetailPesanan();
                    $detail->forceFill(
                        $line + ['id_pesanan' => $order->getKey()]
                    )->save();

                    
                    if ($meta) {
                        DB::table('detail_prints')->insert([
                            'id_detail'           => $detail->getKey(),
                            'nama_file'           => $meta['nama_file'],
                            'path_file'           => $meta['path_file'],
                            'jumlah_halaman'      => $meta['jumlah_halaman'],
                            'halaman_dipilih'     => $meta['halaman_dipilih'],
                            'halaman_hitam_putih' => $meta['halaman_hitam_putih'],
                            'halaman_warna'       => $meta['halaman_warna'],
                            'jumlah_cetak'        => $meta['jumlah_cetak'],
                            'total_harga'         => $meta['total_harga'],
                            'status_verifikasi'   => 'menunggu_verifikasi',
                            'catatan_admin'       => null,
                            'catatan_pelanggan'   => $meta['catatan_pelanggan'] ?? null,
                            'created_at'          => now(),
                            'updated_at'          => now(),
                        ]);

                        continue; // Jasa cetak tidak mengurangi stok
                    }


                    Produk::where('id_produk', $line['id_produk'])
                        ->decrement('stok', $line['jumlah']);
                }

                // Data pengantaran
                if ($diantar) {
                    DB::table('pengantaran')->insert([
                        'alamat_tujuan'      => $lokasi,
                        'nomor_hp'           => $nomorHp,
                        'biaya_pengantaran'  => 0,
                        'status_pengantaran' => 'menunggu',
                        'waktu_pengantaran'  => null,
                        'id_pesanan'         => $order->getKey(),
                    ]);
                }

                return $order;
            });

        } catch (RuntimeException $e) {
            return redirect()
                ->route('pelanggan.keranjang.index')
                ->with('error', $e->getMessage());
        }

        /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI PESANAN BARU
        |--------------------------------------------------------------------------
        | Penerima hanya Admin yang memiliki id_group sama.
        */

        try {
            $admins = Admin::where('id_group', $idGroup)->get();

            if ($admins->isNotEmpty()) {
                Notification::send(
                    $admins,
                    new PesananAdminNotification(
                        (int) $order->getKey(),
                        $order->no_resi,
                        'pesanan_baru'
                    )
                );
            } else {
                Log::warning(
                    'Tidak ada Admin penerima notifikasi pesanan.',
                    [
                        'id_group'   => $idGroup,
                        'id_pesanan' => $order->getKey(),
                    ]
                );
            }
        } catch (\Throwable $e) {
            Log::error(
                'Gagal mengirim notifikasi pesanan baru.',
                [
                    'id_pesanan' => $order->getKey(),
                    'id_group'   => $idGroup,
                    'error'      => $e->getMessage(),
                ]
            );
        }

        // Hapus item yang sudah dipesan dari keranjang
        $cart      = session('keranjang', []);
        $jobsCetak = session('keranjang_cetak', []);

        foreach ($items as $item) {
            if ($item['tipe'] === 'cetak') {
                // File TIDAK dihapus, karena sudah dipakai pesanan
                unset($jobsCetak[$item['job_id']]);
            } else {
                unset($cart[$item['id_produk']]);
            }
        }

        session([
            'keranjang'       => $cart,
            'keranjang_cetak' => $jobsCetak,
        ]);

        session()->forget(['checkout_items', 'checkout_cetak']);

        session([
            'pesanan_terakhir' => $order->no_resi,
        ]);

        return redirect()
            ->route('pelanggan.pembayaran')
            ->with(
                'success',
                'Pesanan ' . $order->no_resi .
                ' berhasil dibuat. Silakan lakukan pembayaran.'
            );
    }

    /**
     * Hanya grup Neo Combi yang menyediakan pengantaran.
     */
    private function bisaAntar(string $namaGroup): bool
    {
        return stripos($namaGroup, 'combi') !== false;
    }

    /**
     * Baris checkout dari pilihan di keranjang (produk biasa + job cetak).
     * Harga produk selalu diambil dari database.
     */
    private function items(): Collection
    {
        $pilihan = session('checkout_items', []);

        $jobs = collect(session('keranjang_cetak', []))
            ->only(session('checkout_cetak', []));

        if (empty($pilihan) && $jobs->isEmpty()) {
            return collect();
        }

        $produk = empty($pilihan)
            ? collect()
            : Produk::aktif()
                ->with('toko')
                ->whereIn('id_produk', array_keys($pilihan))
                ->get();

        $idGroups = $produk
            ->map(fn ($p) => (int) ($p->toko->id_group ?? 0))
            ->merge($jobs->pluck('id_group')->map(fn ($g) => (int) $g))
            ->unique()
            ->filter()
            ->values(); 

        $namaGroup = ManagementGroup::whereIn('id_group', $idGroups)
            ->pluck('nama_group', 'id_group');

        $itemProduk = $produk->map(function ($p) use ($pilihan, $namaGroup) {
            $idGroup = (int) ($p->toko->id_group ?? 0);
            $jumlah  = (int) $pilihan[(int) $p->id_produk];
            $harga   = (int) round($p->harga);

            return [
                'tipe'       => 'produk',
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
        });

        $itemCetak = $jobs->map(function ($j) use ($namaGroup) {
            $idGroup = (int) $j['id_group'];

            return [
                'tipe'       => 'cetak',
                'job_id'     => $j['job_id'],
                'id_produk'  => (int) $j['id_produk'],
                'nama'       => 'Cetak: ' . $j['nama_file'],
                'gambar'     => null,
                'harga'      => (int) $j['total_harga'],
                'jumlah'     => 1,
                'subtotal'   => (int) $j['total_harga'],
                'nama_toko'  => $j['nama_toko'],
                'id_group'   => $idGroup,
                'nama_group' => $namaGroup[$idGroup] ?? 'Tanpa Grup',
                'cetak'      => $j,
            ];
        });

        return $itemProduk->concat($itemCetak)->values();
    }

    private function guard(Collection $items)
    {
        if ($items->isEmpty()) {
            return redirect()
                ->route('pelanggan.keranjang.index')
                ->with('error', 'Pilih produk di keranjang terlebih dahulu.');
        }

        // Semua item checkout harus dari satu grup
        if ($items->pluck('id_group')->unique()->count() > 1) {
            return redirect()
                ->route('pelanggan.keranjang.index')
                ->with(
                    'error',
                    'Produk dari grup berbeda tidak bisa di-checkout bersamaan.'
                );
        }

        return null;
    }

    private function generateResi(): string
    {
        do {
            $resi = 'NXM-' . now()->format('Ymd') .
                '-' . strtoupper(Str::random(5));
        } while (Pesanan::where('no_resi', $resi)->exists());

        return $resi;
    }
}