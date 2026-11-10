<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\ManagementGroup;
use App\Models\Produk;
use App\Models\Toko;
use App\Services\PageCounter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CetakController extends Controller
{
    /**
     * Form pesan cetak.
     */
    public function create()
    {
        $tokoCetak = Toko::where('bisa_cetak', true)
            ->orderBy('nama_toko')
            ->get();

        $tarif = [
            'hitam_putih' => (int) config('cetak.harga_hitam_putih'),
            'warna' => (int) config('cetak.harga_warna'),
        ];

        return view('pelanggan.cetak.create', compact(
            'tokoCetak',
            'tarif'
        ));
    }

    /**
     * Menghitung jumlah halaman file.
     */
    public function hitungHalaman(Request $request)
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png',
                'max:10240',
            ],
        ]);

        return response()->json([
            'halaman' => PageCounter::count(
                $request->file('file')
            ),
        ]);
    }

    /**
     * Menambahkan pekerjaan cetak ke keranjang.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_toko' => [
                'required',
                'integer',
            ],

            'file' => [
                'required',
                'file',
                'mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png',
                'max:10240',
            ],

            'jumlah_halaman' => [
                'required',
                'integer',
                'min:1',
                'max:1000',
            ],

            'halaman_dipilih' => [
                'required',
                'string',
                'max:100',
            ],

            'jenis_cetak' => [
                'required',
                'in:hitam_putih,warna,campuran',
            ],

            'halaman_hitam_putih' => [
                'required_if:jenis_cetak,campuran',
                'nullable',
                'integer',
                'min:0',
                'max:1000',
            ],

            'halaman_warna' => [
                'required_if:jenis_cetak,campuran',
                'nullable',
                'integer',
                'min:0',
                'max:1000',
            ],

            'jumlah_cetak' => [
                'required',
                'integer',
                'min:1',
                'max:100',
            ],

            'catatan_pelanggan' => [
                'nullable',
                'string',
                'max:500',
            ],

        ], [
            'file.required' => 'Silakan upload file terlebih dahulu.',
            'file.mimes' => 'Format file harus PDF, DOC, DOCX, PPT, PPTX, JPG, atau PNG.',
            'file.max' => 'Ukuran file maksimal 10 MB.',
            'jumlah_halaman.required' => 'Jumlah halaman wajib diisi.',
            'halaman_dipilih.required' => 'Halaman yang dicetak wajib diisi.',
            'jenis_cetak.required' => 'Pilih jenis cetak.',
            'jumlah_cetak.required' => 'Jumlah salinan wajib diisi.',
            'halaman_hitam_putih.required_if' => 'Jumlah halaman hitam putih wajib diisi.',
            'halaman_warna.required_if' => 'Jumlah halaman warna wajib diisi.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | VALIDASI TOKO
        |--------------------------------------------------------------------------
        */

        $toko = Toko::where('id_toko', $validated['id_toko'])
            ->where('bisa_cetak', true)
            ->first();

        if (!$toko) {
            return back()
                ->withInput()
                ->withErrors([
                    'id_toko' => 'Toko ini tidak menyediakan layanan cetak.',
                ]);
        }

        $idGroup = $toko->id_group;

        $groupAktif = $idGroup
            && ManagementGroup::where('id_group', $idGroup)
                ->where('status', 'aktif')
                ->exists();

        if (!$groupAktif) {
            return back()
                ->withInput()
                ->withErrors([
                    'id_toko' => 'Toko ini belum bisa menerima pesanan.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | PRODUK PENGHUBUNG JASA CETAK
        |--------------------------------------------------------------------------
        */

        $produk = Produk::aktif()
            ->where('id_toko', $toko->id_toko)
            ->where(
                'nama_produk',
                config('cetak.nama_produk_jasa')
            )
            ->first();

        if (!$produk) {
            return back()
                ->withInput()
                ->withErrors([
                    'id_toko' => 'Layanan cetak toko ini belum siap. Hubungi admin toko.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | HITUNG JUMLAH HALAMAN
        |--------------------------------------------------------------------------
        */

        $terdeteksi = PageCounter::count(
            $request->file('file')
        );

        if ($terdeteksi) {
            $validated['jumlah_halaman'] = $terdeteksi;
        }

        $jumlahHalaman = (int) $validated['jumlah_halaman'];

        $dicetak = $this->hitungHalamanDipilih(
            $validated['halaman_dipilih'],
            $jumlahHalaman
        );

        if ($dicetak < 1) {
            return back()
                ->withInput()
                ->withErrors([
                    'halaman_dipilih' => 'Format halaman tidak valid. Contoh: 1-5, 8 atau semua.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | HITUNG JENIS CETAK
        |--------------------------------------------------------------------------
        */

        if ($validated['jenis_cetak'] === 'hitam_putih') {

            $bw = $dicetak;
            $warna = 0;

        } elseif ($validated['jenis_cetak'] === 'warna') {

            $bw = 0;
            $warna = $dicetak;

        } else {

            $bw = (int) $validated['halaman_hitam_putih'];
            $warna = (int) $validated['halaman_warna'];

            if ($bw + $warna !== $dicetak) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'halaman_hitam_putih' => 'Jumlah halaman hitam putih dan warna harus sama dengan jumlah halaman yang dipilih.',
                    ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | HITUNG TOTAL HARGA
        |--------------------------------------------------------------------------
        */

        $salinan = (int) $validated['jumlah_cetak'];

        $hargaBw = (int) config('cetak.harga_hitam_putih');
        $hargaWarna = (int) config('cetak.harga_warna');

        $totalHarga = (
            ($bw * $hargaBw) +
            ($warna * $hargaWarna)
        ) * $salinan;

        /*
        |--------------------------------------------------------------------------
        | SIMPAN FILE
        |--------------------------------------------------------------------------
        */

        $file = $request->file('file');

        $path = $file->store(
            'cetak/' . now()->format('Y/m'),
            'local'
        );

        /*
        |--------------------------------------------------------------------------
        | BUAT ITEM KERANJANG CETAK
        |--------------------------------------------------------------------------
        */

        $jobId = (string) Str::uuid();

        $job = [
            'job_id' => $jobId,

            'id_produk' => (int) $produk->id_produk,
            'id_toko' => (int) $toko->id_toko,
            'id_group' => (int) $idGroup,

            'nama_toko' => $toko->nama_toko,

            'nama_file' => $file->getClientOriginalName(),
            'path_file' => $path,

            'jumlah_halaman' => $jumlahHalaman,
            'halaman_dipilih' => $validated['halaman_dipilih'],

            'jenis_cetak' => $validated['jenis_cetak'],

            'halaman_hitam_putih' => $bw,
            'halaman_warna' => $warna,

            'jumlah_cetak' => $salinan,

            'harga_hitam_putih' => $hargaBw,
            'harga_warna' => $hargaWarna,

            'total_harga' => $totalHarga,

            'catatan_pelanggan' => $validated['catatan_pelanggan'] ?? null,

            'created_at' => now()->toDateTimeString(),
        ];

        /*
        |--------------------------------------------------------------------------
        | MASUKKAN KE SESSION KERANJANG
        |--------------------------------------------------------------------------
        */

        $keranjangCetak = session('keranjang_cetak', []);

        $keranjangCetak[$jobId] = $job;

        session([
            'keranjang_cetak' => $keranjangCetak,
        ]);

        /*
        |--------------------------------------------------------------------------
        | REDIRECT KE KERANJANG
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('pelanggan.keranjang.index')
            ->with(
                'success',
                'Jasa cetak berhasil ditambahkan ke keranjang.'
            );
    }

    /**
     * Menghitung jumlah halaman yang dipilih.
     * Contoh: 1-5, 8 atau semua.
     */
    private function hitungHalamanDipilih(
        ?string $input,
        int $total
    ): int {

        $input = trim((string) $input);

        if ($input === '' || strtolower($input) === 'semua') {
            return $total;
        }

        $halaman = [];

        foreach (explode(',', $input) as $bagian) {

            $bagian = trim($bagian);

            if (preg_match('/^(\d+)\s*-\s*(\d+)$/', $bagian, $m)) {

                $a = (int) $m[1];
                $b = (int) $m[2];

                if ($a > $b) {
                    [$a, $b] = [$b, $a];
                }

                for (
                    $i = max($a, 1);
                    $i <= min($b, $total);
                    $i++
                ) {
                    $halaman[$i] = true;
                }

            } elseif (ctype_digit($bagian)) {

                $n = (int) $bagian;

                if ($n >= 1 && $n <= $total) {
                    $halaman[$n] = true;
                }
            }
        }

        return count($halaman);
    }
}
