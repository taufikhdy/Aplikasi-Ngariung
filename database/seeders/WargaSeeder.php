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
            'nama' => 'Pak RT',
            'nik' => '1234',
            'jenis_kelamin' => 'laki-laki',
            'tanggal_lahir' => '2007-11-22',
            'agama' => 'islam',
            'pendidikan' => 'S1',
            'pekerjaan' => 'bekerja',
            'status_perkawinan' => 'belum_kawin',
            'status_keluarga' => 'Kepala',
            'telepon' => '087736687006',
            'kk_id' => 1
        ]);
    }
}
