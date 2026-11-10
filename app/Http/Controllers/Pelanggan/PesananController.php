<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function lacak()
    {
        $pesanans = Pesanan::where('id_pelanggan', auth('pelanggan')->id())
            ->whereNotIn('status_pesanan', ['selesai', 'dibatalkan'])
            ->orderByDesc('tanggal_pesanan')
            ->get();

        return view('pelanggan.lacak-pesanan.index', compact('pesanans'));
    }

    public function show($id)
    {
        $pesanan = Pesanan::with([
            'detail.produk',
            'detail.detailPrints',
        ])
            ->where('id_pelanggan', auth('pelanggan')->id())
            ->findOrFail($id);

        return view('pelanggan.pesanan.show', compact('pesanan'));
    }

    public function riwayat()
    {
        $riwayat = Pesanan::where('id_pelanggan', auth('pelanggan')->id())
            ->with([
                'detail.detailPrints',
            ])
            ->orderByDesc('tanggal_pesanan')
            ->paginate(10);

        return view('pelanggan.pesanan.riwayat', compact('riwayat'));
    }
}
