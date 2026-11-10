<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Admin extends Model
{
    use Notifiable;

    protected $table = 'admin';
    protected $primaryKey = 'id_admin';

    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'id_group',
        'id_toko',
    ];

    protected $hidden = [
        'password',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(
            ManagementGroup::class,
            'id_group',
            'id_group'
        );
    }

    public function toko(): BelongsTo
    {
        return $this->belongsTo(
            Toko::class,
            'id_toko',
            'id_toko'
        );
    }
}
