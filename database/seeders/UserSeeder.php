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

        $wargas = Warga::latest()->first();

            User::create([
                'nik' => $wargas->nik,
                'password' => Hash::make('password123'),
                'warga_id' => $wargas->id,
                'role_id' => 1,
                'created_at' => $wargas->created_at
            ]);
    }
}
