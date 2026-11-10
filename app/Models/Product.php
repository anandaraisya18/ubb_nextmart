<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'produk';

    protected $primaryKey = 'id_produk';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'nama_produk',
        'deskripsi',
        'harga',
        'stok',
        'gambar',
        'status',
        'id_kategori',
        'id_toko',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'stok' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Accessor agar Blade lama tetap bisa menggunakan $product->id
    |--------------------------------------------------------------------------
    */

    public function scopeMilikGroup($query)
    {
        return $query->whereHas('toko', fn ($t) => $t->where('id_group', session('admin_group_id')));
    }

    public function getIdAttribute()
    {
        return $this->id_produk;
    }

    /*
    |--------------------------------------------------------------------------
    | Accessor agar Blade bisa menggunakan nama Inggris
    |--------------------------------------------------------------------------
    */

    public function getNameAttribute()
    {
        return $this->nama_produk;
    }

    public function getDescriptionAttribute()
    {
        return $this->deskripsi;
    }

    public function getPriceAttribute()
    {
        return $this->harga;
    }

    public function getStockAttribute()
    {
        return $this->stok;
    }

    public function getImageAttribute()
    {
        return $this->gambar;
    }
}