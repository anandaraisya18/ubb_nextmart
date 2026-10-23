<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Pesanan extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    public $timestamps = false; // hapus baris ini jika tabel punya created_at/updated_at

    protected $fillable = [
        'no_resi', 'tipe_transaksi', 'jenis_pengambilan', 'tanggal_pesanan',
        'subtotal', 'total', 'status_pesanan', 'id_pelanggan',
    ];

    protected $casts = [
        'tanggal_pesanan' => 'datetime',
        'subtotal'        => 'integer',
        'total'           => 'integer',
    ];

    // Sesuaikan nilai (key) dengan isi kolom di database Anda
    public const STATUS = [
        'menunggu_pembayaran' => 'Menunggu Pembayaran',
        'menunggu_verifikasi' => 'Menunggu Verifikasi',
        'diproses'            => 'Diproses',
        'siap_diambil'        => 'Siap Diambil',
        'selesai'             => 'Selesai',
        'dibatalkan'          => 'Dibatalkan',
    ];

    public const TIPE = [
        'online'  => 'Online',
        'offline' => 'Offline',
    ];

    public const PENGAMBILAN = [
        'ambil_di_tempat' => 'Ambil di Tempat',
        'diantar'         => 'Diantar',
    ];

    // Agar route('admin.orders.show', $order) memakai id_pesanan
    public function getRouteKeyName(): string
    {
        return 'id_pesanan';
    }

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function detail(): HasMany
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan', 'id_pesanan');
    }

    /**
     * Batalkan pesanan dan kembalikan stok produknya.
     * Baris pesanan dikunci agar tidak dibatalkan dua kali secara bersamaan.
     */
    public function batalkan(): bool
    {
        return DB::transaction(function () {
            $order = static::whereKey($this->getKey())->lockForUpdate()->first();

            if (! $order || $order->status_pesanan === 'dibatalkan') {
                return false;
            }

            foreach ($order->detail as $detail) {
                Produk::where('id_produk', $detail->id_produk)
                    ->increment('stok', $detail->jumlah);
            }

            $order->status_pesanan = 'dibatalkan';
            $order->save();

            $this->status_pesanan = 'dibatalkan';

            return true;
        });
    }
}