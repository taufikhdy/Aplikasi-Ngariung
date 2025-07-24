<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kas extends Model
{
    //
    protected $table = 'kas';

    protected $fillable = [
        'nama_kas',
        'saldo',
        'deskripsi_kas'
    ];

    public function transaksi(){
        return $this->hasMany(TransaksiKas::class);
    }
}
