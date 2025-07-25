<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    protected $table = 'surat';

    protected $fillable =
    [
        'jenis_surat_id',
        'warga_id',
        'status',
        'file_pdf',
    ];

    public function jenisSurat(){
        return $this->belongsTo(JenisSurat::class);
    }

    public function warga(){
        return $this->belongsTo(Warga::class);
    }

    public function skck(){
        return $this->hasOne(SuratSKCK::class);
    }
}
