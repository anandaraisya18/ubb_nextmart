<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Toko extends Model
{
    protected $table = 'toko';

    protected $primaryKey = 'id_toko';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'id_group',
        'nama_toko',
        'deskripsi',
        'alamat',
        'nomor_telepon',
        'jam_operasional',
        'link_instagram',
        'link_tiktok',
        'bisa_cetak',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(
            ManagementGroup::class,
            'id_group',
            'id_group'
        );
    }

    protected $casts = [
    'bisa_cetak' => 'boolean',
    ];
}