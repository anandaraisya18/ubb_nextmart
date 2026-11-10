<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\ManagementGroup;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KeranjangController extends Controller
{
    /**
     * Menampilkan keranjang produk dan pekerjaan cetak.
     *
     * Session produk:
     * keranjang = [id_produk => jumlah]
     *
     * Session cetak:
     * keranjang_cetak = [job_id => data_pekerjaan_cetak]
     */
    public function index()
    {
        $cart = session('keranjang', []);
        $jobs = collect(session('keranjang_cetak', []));

        // Ambil produk yang ada di keranjang.
        $produk = empty($cart)
            ? collect()
            : Produk::aktif()
                ->with('toko')
                ->whereIn('id_produk', array_keys($cart))
                ->get();

        // Gabungkan ID grup produk dan pekerjaan cetak.
        $idGroups = $produk
            ->map(fn ($p) => (int) ($p->toko->id_group ?? 0))
            ->merge(
                $jobs->pluck('id_group')->map(fn ($g) => (int) $g)
            )
            ->unique()
            ->filter()
            ->values();

        $namaGroup = ManagementGroup::whereIn('id_group', $idGroups)
            ->pluck('nama_group', 'id_group');

        // Kelompokkan isi keranjang berdasarkan grup toko.
        $groups = $idGroups->map(function ($idGroup) use (
            $produk,
            $jobs,
            $cart,
            $namaGroup
        ) {
            // Produk biasa.
            $items = $produk
                ->filter(fn ($p) =>
                    (int) ($p->toko->id_group ?? 0) === (int) $idGroup
                )
                ->map(function ($p) use ($cart) {
                    $stok = (int) $p->stok;
                    $jumlah = (int) ($cart[$p->id_produk] ?? 1);

                    $jumlah = max(
                        1,
                        $stok > 0 ? min($jumlah, $stok) : 1
                    );

                    $harga = (int) round($p->harga);

                    return [
                        'id_produk' => (int) $p->id_produk,
                        'id_group' => (int) ($p->toko->id_group ?? 0),
                        'nama' => $p->nama_produk,
                        'gambar' => $p->gambar,
                        'harga' => $harga,
                        'stok' => $stok,
                        'jumlah' => $jumlah,
                        'subtotal' => $harga * $jumlah,
                        'nama_toko' => $p->toko->nama_toko ?? 'Toko',
                    ];
                })
                ->values()
                ->all();

            // Pekerjaan cetak.
            $cetak = $jobs
                ->filter(fn ($j) =>
                    (int) ($j['id_group'] ?? 0) === (int) $idGroup
                )
                ->values()
                ->all();

            return [
                'id_group' => (int) $idGroup,
                'nama_group' => $namaGroup[$idGroup] ?? 'Tanpa Grup',
                'items' => $items,
                'cetak' => $cetak,
            ];
        })->values();

        return view('pelanggan.keranjang.index', compact('groups'));
    }

    /**
     * Menambahkan produk biasa ke keranjang.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_produk' => [
                'required',
                'integer',
                'exists:produk,id_produk',
            ],
            'jumlah' => [
                'nullable',
                'integer',
                'min:1',
                'max:999',
            ],
        ]);

        $produk = Produk::aktif()
            ->with('toko')
            ->where('id_produk', $data['id_produk'])
            ->first();

        if (! $produk) {
            return back()->with('error', 'Produk tidak tersedia.');
        }

        if ((int) $produk->stok < 1) {
            return back()->with('error', 'Stok produk habis.');
        }

        $idGroup = $produk->toko->id_group ?? null;

        $groupAktif = $idGroup
            && ManagementGroup::where('id_group', $idGroup)
                ->where('status', 'aktif')
                ->exists();

        if (! $groupAktif) {
            return back()->with(
                'error',
                'Produk ini belum bisa dibeli saat ini.'
            );
        }

        $cart = session('keranjang', []);

        $idProduk = (int) $produk->id_produk;
        $maks = (int) $produk->stok;

        $baru = ($cart[$idProduk] ?? 0)
            + (int) ($data['jumlah'] ?? 1);

        $cart[$idProduk] = min($baru, $maks);

        session(['keranjang' => $cart]);

        return back()->with(
            'success',
            $baru > $maks
                ? "Jumlah disesuaikan dengan stok tersedia ({$maks})."
                : $produk->nama_produk . ' ditambahkan ke keranjang.'
        );
    }

    /**
     * Mengubah jumlah produk di keranjang.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'jumlah' => [
                'required',
                'integer',
                'min:1',
                'max:1000',
            ],
        ]);

        $cart = session('keranjang', []);

        if (isset($cart[$id])) {
            $produk = Produk::aktif()
                ->where('id_produk', $id)
                ->first();

            if (! $produk || (int) $produk->stok < 1) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Produk tidak tersedia atau stok habis.',
                ], 422);
            }

            $stok = (int) $produk->stok;

            $cart[$id] = min(
                (int) $data['jumlah'],
                $stok
            );

            session(['keranjang' => $cart]);
        }

        return response()->json(['ok' => true]);
    }

    /**
     * Menghapus produk biasa dari keranjang.
     */
    public function destroy($id)
    {
        $cart = session('keranjang', []);

        unset($cart[$id]);

        session(['keranjang' => $cart]);

        return response()->json(['ok' => true]);
    }

    /**
     * Menghapus pekerjaan cetak dari keranjang.
     */
    public function destroyCetak($jobId)
    {
        $jobs = session('keranjang_cetak', []);

        if (! isset($jobs[$jobId])) {
            return response()->json([
                'ok' => false,
                'message' => 'Pekerjaan cetak tidak ditemukan.',
            ], 404);
        }

        $job = $jobs[$jobId];

        // Hapus file yang sudah diunggah.
        if (! empty($job['path_file'])) {
            Storage::disk('local')->delete($job['path_file']);
        }

        unset($jobs[$jobId]);

        session(['keranjang_cetak' => $jobs]);

        // Bersihkan juga pilihan checkout jika pekerjaan sudah dipilih.
        $checkoutCetak = session('checkout_cetak', []);

        $checkoutCetak = array_values(array_diff(
            $checkoutCetak,
            [$jobId]
        ));

        session(['checkout_cetak' => $checkoutCetak]);

        return response()->json(['ok' => true]);
    }

    /**
     * Memproses pilihan produk dan pekerjaan cetak
     * sebelum diarahkan ke halaman checkout.
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'items' => ['nullable', 'array'],
            'items.*' => ['integer'],
            'cetak' => ['nullable', 'array'],
            'cetak.*' => ['string'],
            'qty' => ['nullable', 'array'],
            'qty.*' => ['nullable', 'integer', 'min:1', 'max:1000'],
        ]);

        $cart = session('keranjang', []);
        $jobs = session('keranjang_cetak', []);

        // Produk yang dipilih pelanggan.
        $idDipilih = array_values(array_intersect(
            array_map('intval', (array) $request->input('items', [])),
            array_map('intval', array_keys($cart))
        ));

        // Pekerjaan cetak yang dipilih pelanggan.
        $cetak = array_values(array_intersect(
            (array) $request->input('cetak', []),
            array_keys($jobs)
        ));

        if (empty($idDipilih) && empty($cetak)) {
            return redirect()
                ->route('pelanggan.keranjang.index')
                ->with(
                    'error',
                    'Pilih minimal satu produk atau pekerjaan cetak.'
                );
        }

        $pilihan = [];

        // Validasi ulang produk dan stok.
        if (! empty($idDipilih)) {
            $produkTersedia = Produk::aktif()
                ->whereIn('id_produk', $idDipilih)
                ->get()
                ->keyBy('id_produk');

            foreach ($idDipilih as $id) {
                if (! $produkTersedia->has($id)) {
                    continue;
                }

                $produk = $produkTersedia[$id];
                $stok = (int) $produk->stok;

                if ($stok < 1) {
                    continue;
                }

                $jumlah = (int) (
                    $request->input("qty.$id")
                    ?? ($cart[$id] ?? 1)
                );

                $jumlah = max(1, min($jumlah, $stok));

                $pilihan[$id] = $jumlah;
                $cart[$id] = $jumlah;
            }

            session(['keranjang' => $cart]);
        }

        // Pastikan pekerjaan cetak masih memiliki file.
        foreach ($cetak as $jobId) {
            $job = $jobs[$jobId] ?? null;

            if (! $job) {
                continue;
            }

            if (
                empty($job['path_file'])
                || ! Storage::disk('local')->exists($job['path_file'])
            ) {
                unset($jobs[$jobId]);
            }
        }

        // Simpan kembali pekerjaan cetak yang masih valid.
        session(['keranjang_cetak' => $jobs]);

        $cetak = array_values(array_filter(
            $cetak,
            fn ($jobId) => isset($jobs[$jobId])
        ));

        if (empty($pilihan) && empty($cetak)) {
            return redirect()
                ->route('pelanggan.keranjang.index')
                ->with(
                    'error',
                    'Produk atau pekerjaan cetak yang dipilih sudah tidak tersedia.'
                );
        }

        // Simpan pilihan untuk diproses oleh CheckoutController.
        session([
            'checkout_items' => $pilihan,
            'checkout_cetak' => $cetak,
        ]);

        return redirect()->route('pelanggan.checkout');
    }
}
