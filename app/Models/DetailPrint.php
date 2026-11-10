<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPrint extends Model
{
    protected $table = 'detail_prints';

    protected $fillable = [
        'id_detail',
        'nama_file',
        'path_file',
        'jumlah_halaman',
        'halaman_dipilih',
        'halaman_hitam_putih',
        'halaman_warna',
        'jumlah_cetak',
        'total_harga',
        'status_verifikasi',
        'catatan_admin',
    ];

    protected $casts = [
        'total_harga' => 'float',
    ];

    public const STATUS_VERIFIKASI = [
        'menunggu_verifikasi',
        'selesai',
        'perlu_revisi',
    ];

    public function detailPesanan(): BelongsTo
    {
        // FK di detail_prints = id_detail, PK di detail_pesanan = id_detail
        return $this->belongsTo(DetailPesanan::class, 'id_detail', 'id_detail');
    }
}