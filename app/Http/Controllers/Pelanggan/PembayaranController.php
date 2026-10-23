<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
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

        return view('pelanggan.pembayaran.index', compact('pesanan'));
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
                ->with('error', 'Sesi pesanan tidak ditemukan. Silakan periksa pesanan Anda.');
        }

        $pesanan = Pesanan::where('no_resi', $noResi)->first();

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
            $pesanan->forceFill([
                'bukti_pembayaran' => $pathBaru,
                'status_pesanan' => 'menunggu_verifikasi',
            ])->save();
        } catch (\Throwable $e) {
            Storage::disk('public')->delete($pathBaru);

            throw $e;
        }

        return redirect()
            ->route('pelanggan.pesanan.resi')
            ->with('success', 'Bukti pembayaran berhasil dikirim. Silakan tunggu verifikasi admin.');
    }
}
