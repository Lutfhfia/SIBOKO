<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MahasiswaAdminController extends Controller
{
    public function index()
    {
        $mahasiswas = Mahasiswa::with(['user', 'pembimbing1', 'pembimbing2'])->latest()->get();
        return view('admin.mahasiswa', compact('mahasiswas'));
    }

    public function create()
    {
        $dosens = Dosen::orderBy('nama_dosen')->get();
        return view('admin.mahasiswa-create', compact('dosens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mahasiswa' => 'required|string|max:100',
            'nim' => 'required|string|max:30|unique:users,username',
            'prodi' => 'required|string|max:100',
            'no_hp' => 'nullable|string|max:15',
            'password' => 'required|string|min:6',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'pembimbing1_id' => 'nullable|exists:dosens,id',
            'pembimbing2_id' => 'nullable|exists:dosens,id|different:pembimbing1_id',
        ]);

        $user = User::create([
            'name' => $request->nama_mahasiswa,
            'username' => $request->nim,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_profil')) {
            $fotoPath = $request->file('foto_profil')->store('profil', 'public');
        }

        Mahasiswa::create([
            'user_id' => $user->id,
            'nama_mahasiswa' => $request->nama_mahasiswa,
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'no_hp' => $request->no_hp,
            'foto_profil' => $fotoPath,
            'pembimbing1_id' => $request->pembimbing1_id,
            'pembimbing2_id' => $request->pembimbing2_id,
        ]);

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Data Mahasiswa berhasil ditambahkan.');
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        $dosens = Dosen::orderBy('nama_dosen')->get();
        return view('admin.mahasiswa-edit', compact('mahasiswa', 'dosens'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'nama_mahasiswa' => 'required|string|max:100',
            'prodi' => 'required|string|max:100',
            'no_hp' => 'nullable|string|max:15',
            'password' => 'nullable|string|min:6',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'pembimbing1_id' => 'nullable|exists:dosens,id',
            'pembimbing2_id' => 'nullable|exists:dosens,id|different:pembimbing1_id',
        ]);

        $user = $mahasiswa->user;
        $user->name = $request->nama_mahasiswa;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        if ($request->hasFile('foto_profil')) {
            if ($mahasiswa->foto_profil) {
                Storage::disk('public')->delete($mahasiswa->foto_profil);
            }
            $mahasiswa->foto_profil = $request->file('foto_profil')->store('profil', 'public');
        }

        $mahasiswa->nama_mahasiswa = $request->nama_mahasiswa;
        $mahasiswa->prodi = $request->prodi;
        $mahasiswa->no_hp = $request->no_hp;
        $mahasiswa->pembimbing1_id = $request->pembimbing1_id;
        $mahasiswa->pembimbing2_id = $request->pembimbing2_id;
        $mahasiswa->save();

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Data Mahasiswa berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        if ($mahasiswa->foto_profil) {
            Storage::disk('public')->delete($mahasiswa->foto_profil);
        }
        
        $mahasiswa->user->delete();
        
        return redirect()->route('admin.mahasiswa.index')->with('success', 'Data Mahasiswa berhasil dihapus.');
    }
}
