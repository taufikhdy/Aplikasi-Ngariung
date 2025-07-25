<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    protected $table = 'jenis_surat';

    protected $fillable =
    [
        'nama_jenis',
    ];

    public function surat(){
        return $this->hasMany(Surat::class);
    }
}
