<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class KK_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kartu_keluarga')->insert([
            'no_kk' => '003214',
            'alamat' => 'cibingbin',
            'rt' => '01',
            'rw' => '01'
        ]);
    }
}
