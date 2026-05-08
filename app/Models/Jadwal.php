<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $fillable = [
        'dosen_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'kuota',
        'keterangan',
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }
}
