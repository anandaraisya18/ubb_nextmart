<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailPrint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PrintController extends Controller
{
    /**
     * Disk tempat file cetak disimpan.
     * Sesuaikan dengan disk yang dipakai saat pelanggan upload.
     */
    private const DISK = 'local';

    /**
     * Query dasar: hanya file cetak dari toko yang
     * (1) satu group dengan admin yang login, dan
     * (2) layanan cetaknya aktif.
     */
    private function scopedQuery()
    {
        $groupId = session('admin_group_id');

        return DetailPrint::query()
            ->whereHas('detailPesanan.produk.toko', function ($q) use ($groupId) {
                $q->where('id_group', $groupId)
                  ->where('bisa_cetak', true);
            });
    }

    /**
     * Antrian cetak.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('search');

        $prints = $this->scopedQuery()
            ->with(['detailPesanan.pesanan', 'detailPesanan.produk.toko'])
            ->when($status, fn ($q) => $q->where('status_verifikasi', $status))
            ->when($search, function ($q) use ($search) {
                $q->where(function ($w) use ($search) {
                    $w->where('nama_file', 'like', "%{$search}%")
                      ->orWhereHas('detailPesanan.pesanan', function ($p) use ($search) {
                          $p->where('no_resi', 'like', "%{$search}%");
                      });
                });
            })
            ->latest('created_at')
            ->paginate(15)
            ->withQueryString();

        // Ringkasan jumlah per status.
        $summary = [
            'menunggu_verifikasi' => $this->scopedQuery()
                ->where('status_verifikasi', 'menunggu_verifikasi')
                ->count(),

            'selesai' => $this->scopedQuery()
                ->where('status_verifikasi', 'selesai')
                ->count(),

            'perlu_revisi' => $this->scopedQuery()
                ->where('status_verifikasi', 'perlu_revisi')
                ->count(),
        ];

        return view('admin.prints.index', compact(
            'prints',
            'summary',
            'status',
            'search'
        ));
    }

    /**
     * Detail satu file cetak.
     */
    public function show($id)
    {
        $print = $this->scopedQuery()
            ->with(['detailPesanan.pesanan', 'detailPesanan.produk.toko'])
            ->findOrFail($id);

        return view('admin.prints.show', compact('print'));
    }

    /**
     * Download file milik pelanggan.
     */
    public function download($id)
    {
        $print = $this->scopedQuery()->findOrFail($id);

        abort_unless(
            Storage::disk(self::DISK)->exists($print->path_file),
            404,
            'File tidak ditemukan.'
        );

        return Storage::disk(self::DISK)->download(
            $print->path_file,
            $print->nama_file
        );
    }

    /**
     * Setujui atau tolak file cetak.
     * Tolak = harga pesanan otomatis dikurangi (dan pesanan bisa selesai otomatis).
     */
    public function updateVerifikasi(Request $request, $id)
    {
        $print = $this->scopedQuery()
            ->with('detailPesanan.pesanan')
            ->findOrFail($id);

        $validated = $request->validate([
            'status_verifikasi' => ['required', 'in:selesai,perlu_revisi'],
            'catatan_admin'     => ['nullable', 'required_if:status_verifikasi,perlu_revisi', 'string', 'max:500'],
        ], [
            'status_verifikasi.required' => 'Pilih Setujui atau Tolak.',
            'status_verifikasi.in'       => 'Status verifikasi tidak valid.',
            'catatan_admin.required_if'  => 'Catatan wajib diisi jika file ditolak.',
            'catatan_admin.max'          => 'Catatan maksimal 500 karakter.',
        ]);

        DB::transaction(function () use ($print, $validated) {
            $print->update([
                'status_verifikasi' => $validated['status_verifikasi'],
                'catatan_admin'     => $validated['status_verifikasi'] === 'perlu_revisi'
                    ? $validated['catatan_admin']
                    : null,
            ]);

            $print->detailPesanan->pesanan->hitungUlangPotongan();
        });

        $pesanan = $print->detailPesanan->pesanan->fresh();

        $pesan = 'File disetujui.';
        if ($validated['status_verifikasi'] === 'perlu_revisi') {
            $pesan = 'File ditolak. Harga pesanan dikurangi Rp'
                . number_format($print->total_harga, 0, ',', '.')
                . ($pesanan->selesai_otomatis ? ' dan pesanan otomatis selesai.' : '.');
        }

        return redirect()
            ->route('admin.prints.show', $print->id)
            ->with('success', $pesan);
    }
}