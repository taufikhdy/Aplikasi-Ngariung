<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use App\Models\Warga;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $wargas = Warga::take(2)->get();

        foreach ($wargas as $warga) {
            User::create([
                'nik' => $warga->nik,
                'password' => Hash::make('password123'),
                'warga_id' => $warga->id,
                'role_id' => 2,
            ]);
        }
    }
}
