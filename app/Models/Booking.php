<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'dosen_id',
        'mahasiswa_id',
        'nama_mahasiswa',
        'nim',
        'prodi',
        'tanggal',
        'jam',
        'topik',
        'subject',
        'presensi',
        'uraian',
        'status',
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
