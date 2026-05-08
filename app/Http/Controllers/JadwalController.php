<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Menampilkan daftar semua jadwal konsultasi.
     */
    public function index()
    {
        $jadwals = Jadwal::with('dosen')->latest()->get();
        return view('jadwal.index', compact('jadwals'));
    }

    /**
     * Menampilkan form tambah jadwal.
     */
    public function create()
    {
        $dosens = Dosen::orderBy('nama_dosen')->get();
        return view('jadwal.create', compact('dosens'));
    }

    /**
     * Menyimpan jadwal baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
            'hari' => 'required|string|max:20',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'kuota' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        Jadwal::create($request->all());

        return redirect()->route('jadwal.index')->with('success', 'Jadwal konsultasi berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail jadwal.
     */
    public function show(Jadwal $jadwal)
    {
        $jadwal->load('dosen');
        return view('jadwal.show', compact('jadwal'));
    }

    /**
     * Menampilkan form edit jadwal.
     */
    public function edit(Jadwal $jadwal)
    {
        $dosens = Dosen::orderBy('nama_dosen')->get();
        return view('jadwal.edit', compact('jadwal', 'dosens'));
    }

    /**
     * Mengupdate jadwal.
     */
    public function update(Request $request, Jadwal $jadwal)
    {
        $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
            'hari' => 'required|string|max:20',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'kuota' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        $jadwal->update($request->all());

        return redirect()->route('jadwal.index')->with('success', 'Jadwal konsultasi berhasil diperbarui!');
    }

    /**
     * Menghapus jadwal.
     */
    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('jadwal.index')->with('success', 'Jadwal konsultasi berhasil dihapus!');
    }
}
