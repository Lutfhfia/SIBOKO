<?php

namespace Database\Seeders;

use App\Models\Jadwal;
use Illuminate\Database\Seeder;

class JadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jadwals = [
            [
                'dosen_id' => 1,
                'hari' => 'Senin',
                'jam_mulai' => '09:00',
                'jam_selesai' => '11:00',
                'kuota' => 5,
                'keterangan' => 'Konsultasi pemrograman web',
            ],
            [
                'dosen_id' => 1,
                'hari' => 'Rabu',
                'jam_mulai' => '13:00',
                'jam_selesai' => '15:00',
                'kuota' => 4,
                'keterangan' => 'Konsultasi tugas akhir',
            ],
            [
                'dosen_id' => 2,
                'hari' => 'Selasa',
                'jam_mulai' => '08:00',
                'jam_selesai' => '10:00',
                'kuota' => 5,
                'keterangan' => 'Konsultasi basis data',
            ],
            [
                'dosen_id' => 2,
                'hari' => 'Kamis',
                'jam_mulai' => '13:00',
                'jam_selesai' => '15:00',
                'kuota' => 3,
                'keterangan' => 'Bimbingan skripsi',
            ],
            [
                'dosen_id' => 3,
                'hari' => 'Senin',
                'jam_mulai' => '13:00',
                'jam_selesai' => '15:00',
                'kuota' => 4,
                'keterangan' => 'Konsultasi jaringan',
            ],
            [
                'dosen_id' => 3,
                'hari' => 'Jumat',
                'jam_mulai' => '09:00',
                'jam_selesai' => '11:00',
                'kuota' => 3,
                'keterangan' => 'Konsultasi keamanan jaringan',
            ],
            [
                'dosen_id' => 4,
                'hari' => 'Rabu',
                'jam_mulai' => '08:00',
                'jam_selesai' => '10:00',
                'kuota' => 6,
                'keterangan' => 'Bimbingan akademik',
            ],
            [
                'dosen_id' => 5,
                'hari' => 'Kamis',
                'jam_mulai' => '09:00',
                'jam_selesai' => '11:00',
                'kuota' => 5,
                'keterangan' => 'Konsultasi RPL & software engineering',
            ],
        ];

        foreach ($jadwals as $jadwal) {
            Jadwal::create($jadwal);
        }
    }
}
