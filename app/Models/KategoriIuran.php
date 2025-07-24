<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriIuran extends Model
{
    //
    protected $table = 'kategori_iuran';

    protected $fillable = [
        'nama_iuran',
        'jumlah',
        'tanggal_mulai',
        'tanggal_akhir',
        'deskripsi',
    ];

    public function iuran()
    {
        return $this->hasMany(transaksiIuran::class);
    }
}
