<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class WargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('warga')->insert([
            'nama' => 'taufik',
            'nik' => '3214',
            'jenis_kelamin' => 'laki-laki',
            'tanggal_lahir' => '2007-11-22',
            'agama' => 'islam',
            'pendidikan' => 'smk',
            'pekerjaan' => 'belum_bekerja',
            'status_perkawinan' => 'belum_kawin',
            'status_keluarga' => 'anggota',
            'telepon' => '087736687006',
            'kk_id' => 1
        ]);
    }
}
