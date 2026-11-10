<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'nama_produk', 'deskripsi', 'harga', 'stok',
        'gambar', 'status', 'id_kategori', 'id_toko',
    ];

    protected $casts = [
        'harga' => 'integer',
        'stok'  => 'integer',
    ];

    // Agar route('admin.products.show', $produk) memakai id_produk
    public function getRouteKeyName(): string
    {
        return 'id_produk';
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function toko(): BelongsTo
    {
        return $this->belongsTo(Toko::class, 'id_toko', 'id_toko');
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
    public function scopeMilikGroup($query)
    {
        return $query->whereHas('toko', fn ($t) => $t->where('id_group', session('admin_group_id')));
    }
}