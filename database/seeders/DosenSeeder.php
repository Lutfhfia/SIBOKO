<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dosens = [
            [
                'nama_dosen' => 'Dr. Andi Saputra, M.Kom.',
                'nidn' => '0012345601',
                'bidang_keahlian' => 'Pemrograman Web',
                'email' => 'andi.saputra@univ.ac.id',
                'no_hp' => '081234567890',
            ],
            [
                'nama_dosen' => 'Bu Rina Lestari, S.Kom., M.T.',
                'nidn' => '0012345602',
                'bidang_keahlian' => 'Basis Data',
                'email' => 'rina.lestari@univ.ac.id',
                'no_hp' => '082345678901',
            ],
            [
                'nama_dosen' => 'Pak Budi Hartono, M.Sc.',
                'nidn' => '0012345603',
                'bidang_keahlian' => 'Jaringan Komputer',
                'email' => 'budi.hartono@univ.ac.id',
                'no_hp' => '083456789012',
            ],
            [
                'nama_dosen' => 'Dr. Siti Aminah, M.Pd.',
                'nidn' => '0012345604',
                'bidang_keahlian' => 'Bimbingan Akademik',
                'email' => 'siti.aminah@univ.ac.id',
                'no_hp' => '084567890123',
            ],
            [
                'nama_dosen' => 'Pak Dedi Kurniawan, S.T., M.Eng.',
                'nidn' => '0012345605',
                'bidang_keahlian' => 'Rekayasa Perangkat Lunak',
                'email' => 'dedi.kurniawan@univ.ac.id',
                'no_hp' => '085678901234',
            ],
        ];

        foreach ($dosens as $dosenData) {
            $user = User::create([
                'name' => $dosenData['nama_dosen'],
                'username' => $dosenData['nidn'],
                'email' => $dosenData['email'],
                'password' => Hash::make('password'),
                'role' => 'dosen',
            ]);

            $dosenData['user_id'] = $user->id;
            Dosen::create($dosenData);
        }
    }
}
