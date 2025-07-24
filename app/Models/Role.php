<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    public $timestamps = false;

    protected $fillable = ['nama_role'];

    public function users(){
        return $this->hasMany(User::class);
    }
}
