<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiIuran extends Model
{
    //
    protected $table = 'transaksi_iuran';

    protected $fillable = [
        'kategori_iuran_id',
        'warga_id',
        'tanggal_bayar',
        'jumlah_bayar',
        'bukti_bayar',
        'status',
        'transaksi_kas_id'
    ];

    public function kategoriIuran(){
        return $this->belongsTo(KategoriIuran::class, 'kategori_iuran_id');
    }

    public function warga(){
        return $this->belongsTo(Warga::class);
    }

    public function transaksiKas(){
        return $this->belongsTo(TransaksiKas::class);
    }
}
