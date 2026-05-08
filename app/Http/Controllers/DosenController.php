<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    /**
     * Menampilkan daftar semua dosen.
     */
    public function index()
    {
        $dosens = Dosen::latest()->get();
        return view('dosen.index', compact('dosens'));
    }

    /**
     * Menampilkan form tambah dosen.
     */
    public function create()
    {
        return view('dosen.create');
    }

    /**
     * Menyimpan data dosen baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_dosen' => 'required|string|max:100',
            'nidn' => 'required|string|max:30|unique:dosens,nidn',
            'bidang_keahlian' => 'required|string|max:100',
            'email' => 'nullable|email|max:100',
            'no_hp' => 'nullable|string|max:20',
        ]);

        Dosen::create($request->all());

        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail dosen.
     */
    public function show(Dosen $dosen)
    {
        $dosen->load(['jadwals', 'bookings']);
        return view('dosen.show', compact('dosen'));
    }

    /**
     * Menampilkan form edit dosen.
     */
    public function edit(Dosen $dosen)
    {
        return view('dosen.edit', compact('dosen'));
    }

    /**
     * Mengupdate data dosen.
     */
    public function update(Request $request, Dosen $dosen)
    {
        $request->validate([
            'nama_dosen' => 'required|string|max:100',
            'nidn' => 'required|string|max:30|unique:dosens,nidn,' . $dosen->id,
            'bidang_keahlian' => 'required|string|max:100',
            'email' => 'nullable|email|max:100',
            'no_hp' => 'nullable|string|max:20',
        ]);

        $dosen->update($request->all());

        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil diperbarui!');
    }

    /**
     * Menghapus data dosen.
     */
    public function destroy(Dosen $dosen)
    {
        $dosen->delete();
        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil dihapus!');
    }
}
