<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratSKCK extends Model
{
    protected $table = 'surat_skck';

    protected $fillable =
    [
        'surat_id',
        'nama',
        'nik',
        'alamat',
        'keperluan',
        'tujuan_skck'
    ];

    // public function surat(){
    //     return $this->belongsTo(Surat::class);
    // }
}
