<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $mhsUser = User::create([
            'name' => 'Ahmad Mahasiswa',
            'username' => '12345678',
            'email' => 'ahmad@mahasiswa.com',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
        ]);

        Mahasiswa::create([
            'user_id' => $mhsUser->id,
            'nim' => '12345678',
            'nama_mahasiswa' => 'Ahmad Mahasiswa',
            'prodi' => 'D3 Manajemen Informatika',
            'no_hp' => '08122334455',
        ]);
    }
}
