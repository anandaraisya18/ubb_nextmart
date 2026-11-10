<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.payment.payment', $this->data($request));
    }

    public function export(Request $request)
    {
        return view('admin.payment.export', $this->data($request));
    }

    private function data(Request $request): array
    {
        $request->validate([
            'q'       => ['nullable', 'string', 'max:100'],
            'metode'  => ['nullable', 'string', 'max:50'],
            'periode' => ['nullable', 'in:hari_ini,minggu_ini,bulan_ini'],
        ]);

        $transactions = $this->getTransactions($request);

        return [
            'transactions'      => $transactions,
            'totalTransaksi'    => $transactions->count(),
            'transaksiBerhasil' => $transactions->count(),
            'totalPendapatan'   => $transactions->sum('total'),
            'qrisTotal'         => $transactions->where('payment', 'QRIS')->sum('total'),
            'transferTotal'     => $transactions->where('payment', 'Transfer Bank')->sum('total'),
            'tunaiTotal'        => $transactions->where('payment', 'Tunai')->sum('total'),
        ];
    }

    private function getTransactions(Request $request)
    {
        return DB::table('pesanan')
            ->leftJoin('pelanggan', 'pesanan.id_pelanggan', '=', 'pelanggan.id_pelanggan')
            ->where('pesanan.status_pesanan', 'selesai')
            // Hanya pesanan yang berisi produk dari toko milik group admin ini
            ->whereIn('pesanan.id_pesanan', function ($sub) {
                $sub->select('detail_pesanan.id_pesanan')
                    ->from('detail_pesanan')
                    ->join('produk', 'detail_pesanan.id_produk', '=', 'produk.id_produk')
                    ->join('toko', 'produk.id_toko', '=', 'toko.id_toko')
                    ->where('toko.id_group', session('admin_group_id'));
            })
            ->when($request->filled('q'), function ($query) use ($request) {
                $q = str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $request->q);

                $query->where(function ($sub) use ($q) {
                    $sub->where('pelanggan.nama', 'like', "%{$q}%")
                        ->orWhere('pesanan.id_pesanan', 'like', "%{$q}%")
                        ->orWhere('pesanan.no_resi', 'like', "%{$q}%");
                });
            })
            ->when($request->filled('metode'), function ($query) use ($request) {
                if ($request->metode === 'QRIS') {
                    $query->where('pesanan.tipe_transaksi', 'online');
                } elseif ($request->metode === 'Tunai') {
                    $query->where('pesanan.tipe_transaksi', 'offline');
                } else {
                    $query->whereRaw('1 = 0');
                }
            })
            ->when($request->periode === 'hari_ini', fn ($query) =>
                $query->whereDate('pesanan.tanggal_pesanan', today()))
            ->when($request->periode === 'minggu_ini', fn ($query) =>
                $query->whereBetween('pesanan.tanggal_pesanan', [
                    now()->startOfWeek(),
                    now()->endOfWeek(),
                ]))
            ->when($request->periode === 'bulan_ini', fn ($query) =>
                $query->whereMonth('pesanan.tanggal_pesanan', now()->month)
                    ->whereYear('pesanan.tanggal_pesanan', now()->year))
            ->select(
                'pesanan.id_pesanan as id',
                'pesanan.id_pesanan as order_id',
                'pesanan.no_resi',
                'pesanan.tipe_transaksi',
                'pelanggan.nama as customer',
                'pelanggan.no_hp as phone',
                'pesanan.total',
                'pesanan.status_pesanan as status',
                'pesanan.tanggal_pesanan'
            )
            ->orderByDesc('pesanan.tanggal_pesanan')
            ->get()
            ->map(function ($t) {
                $t->payment = $t->tipe_transaksi === 'online'
                    ? 'QRIS'
                    : 'Tunai';

                $t->date = $t->tanggal_pesanan
                    ? date('d F Y', strtotime($t->tanggal_pesanan))
                    : '-';

                $t->time = $t->tanggal_pesanan
                    ? date('H:i', strtotime($t->tanggal_pesanan))
                    : '-';

                $t->verified_at = '-';
                $t->verified_by = '-';

                return $t;
            });
    }
}