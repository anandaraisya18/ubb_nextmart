<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function lacak(Request $request)
    {
        $resi = trim($request->query('resi', ''));
        $pesanan = null;

        if ($resi !== '') {
            $pesanan = Pesanan::query()
                ->where('no_resi', $resi)
                ->first();

            if ($pesanan) {
                return redirect()->route('pelanggan.pesanan.show', [
                    'id' => $pesanan->id_pesanan,
                ]);
            }
        }

        return view('pelanggan.lacak-pesanan.index', compact(
            'pesanan',
            'resi'
        ));
    }

    public function show($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        return view('pelanggan.pesanan.show', compact('pesanan'));
    }
}
