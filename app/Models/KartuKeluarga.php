<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KartuKeluarga extends Model
{

    protected $table = 'kartu_keluarga';

    protected $fillable = [
        'no_kk',
        'alamat',
        'rt',
        'rw'
    ];

    public function warga()
    {
        return $this->hasMany(Warga::class);
    }
}
