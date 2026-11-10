<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ManagementGroup extends Model
{
    protected $table = 'management_group';

    protected $primaryKey = 'id_group';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'nama_group',
        'status',
    ];

    public function stores(): HasMany
    {
        return $this->hasMany(
            Toko::class,
            'id_group',
            'id_group'
        );
    }
}