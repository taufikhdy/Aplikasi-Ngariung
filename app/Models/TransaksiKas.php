<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiKas extends Model
{
    //
    protected $table = "transaksi_kas";

    protected $fillable = [
        'kas_id',
        'tanggal',
        'jenis',
        'jumlah',
        'keterangan',
        'bukti_transaksi'
    ];

    public function kas(){
        return $this->belongsTo(Kas::class);
    }
}
