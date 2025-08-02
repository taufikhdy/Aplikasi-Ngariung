<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JamOperasional extends Model
{
    //

    protected $fillable = [
        'hari',
        'jam_mulai',
        'jam_selesai',
        'libur'
    ];
}
