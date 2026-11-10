<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\DetailPesanan;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Notifications\PesananAdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    /**
     * Menampilkan halaman pembayaran pesanan terakhir.
     */
    public function index()
    {
        $noResi = session('pesanan_terakhir');

        $pesanan = $noResi
            ? Pesanan::where('no_resi', $noResi)->first()
            : null; 

        return view(
            'pelanggan.pembayaran.index',
            compact('pesanan')
        );
    }

    /**
     * Menyimpan bukti pembayaran pelanggan.
     */
    public function uploadBukti(Request $request)
    {
        $request->validate([
            'proof' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],
        ], [
            'proof.required' => 'Bukti pembayaran wajib diunggah.',
            'proof.image' => 'File harus berupa gambar.',
            'proof.mimes' => 'Format bukti pembayaran harus JPG, JPEG, atau PNG.',
            'proof.max' => 'Ukuran gambar maksimal 2 MB.',
        ]);

        $noResi = session('pesanan_terakhir');

        if (! $noResi) {
            return redirect()
                ->route('pelanggan.keranjang.index')
                ->with(
                    'error',
                    'Sesi pesanan tidak ditemukan. Silakan periksa pesanan Anda.'
                );
        }

        $pesanan = Pesanan::where(
            'no_resi',
            $noResi
        )->first();

        if (! $pesanan) {
            return redirect()
                ->route('pelanggan.keranjang.index')
                ->with('error', 'Pesanan tidak ditemukan.');
        }

        if ($pesanan->status_pesanan !== 'menunggu_pembayaran') {
            return back()->with(
                'error',
                'Bukti pembayaran hanya dapat diunggah untuk pesanan yang menunggu pembayaran.'
            );
        }

        // Simpan file bukti pembayaran
        $pathBaru = $request->file('proof')->store(
            'bukti-pembayaran',
            'public'
        );

        if (! $pathBaru) {
            return back()->with(
                'error',
                'Bukti pembayaran gagal disimpan. Silakan coba kembali.'
            );
        }

        try {
            // Update status pesanan
            $pesanan->forceFill([
                'bukti_pembayaran' => $pathBaru,
                'status_pesanan' => 'menunggu_verifikasi',
            ])->save();

        } catch (\Throwable $e) {
            Storage::disk('public')->delete($pathBaru);

            throw $e;
        }

        /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI BUKTI PEMBAYARAN
        |--------------------------------------------------------------------------
        | Cari produk dari detail pesanan.
        | Ambil id_group melalui relasi toko.
        | Kirim notifikasi ke Admin grup yang sesuai.
        */

        try {
            // Produk yang dibeli pelanggan
            $idProduk = DetailPesanan::where(
                'id_pesanan',
                $pesanan->getKey()
            )->pluck('id_produk');

            // Cari grup toko dari produk tersebut
            $idGroups = Produk::with('toko')
                ->whereIn('id_produk', $idProduk)
                ->get()
                ->map(
                    fn ($produk) => $produk->toko?->id_group
                )
                ->filter()
                ->unique()
                ->values();

            if ($idGroups->isNotEmpty()) {
                // Admin dari grup toko terkait
                $admins = Admin::whereIn(
                    'id_group',
                    $idGroups
                )->get();

                if ($admins->isNotEmpty()) {
                    Notification::send(
                        $admins,
                        new PesananAdminNotification(
                            (int) $pesanan->getKey(),
                            $pesanan->no_resi,
                            'bukti_pembayaran'
                        )
                    );
                } else {
                    Log::warning(
                        'Tidak ada Admin penerima notifikasi pembayaran.',
                        [
                            'id_pesanan' => $pesanan->getKey(),
                            'id_groups' => $idGroups->all(),
                        ]
                    );
                }
            } else {
                Log::warning(
                    'Grup toko untuk notifikasi pembayaran tidak ditemukan.',
                    [
                        'id_pesanan' => $pesanan->getKey(),
                    ]
                );
            }

        } catch (\Throwable $e) {
            Log::error(
                'Gagal mengirim notifikasi pembayaran.',
                [
                    'id_pesanan' => $pesanan->getKey(),
                    'error' => $e->getMessage(),
                ]
            );
        }

        return redirect()
            ->route('pelanggan.pesanan.resi')
            ->with(
                'success',
                'Bukti pembayaran berhasil dikirim. Silakan tunggu verifikasi admin.'
            );
    }
}
