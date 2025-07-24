<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    protected $table = 'warga';

    protected $fillable = [
        'nama',
        'nik',
        'jenis_kelamin',
        'tanggal_lahir',
        'agama',
        'pendidikan',
        'pekerjaan',
        'status_perkawinan',
        'status_keluarga',
        'telepon',
        'kk_id'
    ];

    public function kartuKeluarga()
    {
        return $this->belongsTo(KartuKeluarga::class, 'kk_id');
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function transaksiIuran()
    {
        return $this->hasMany(TransaksiIuran::class);
    }
}
