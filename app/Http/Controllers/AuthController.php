<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $role = Auth::user()->role;

            if ($role == 'admin') {
                return redirect()->intended('/admin')->with('success', 'Selamat datang Admin!');
            } elseif ($role == 'dosen') {
                return redirect()->intended('/dosen-panel')->with('success', 'Selamat datang Dosen!');
            } else {
                return redirect()->intended('/')->with('success', 'Berhasil login sebagai Mahasiswa.');
            }
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nim' => 'required|unique:mahasiswas,nim|unique:users,username',
            'nama_mahasiswa' => 'required|string|max:100',
            'prodi' => 'required|string',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->nama_mahasiswa,
            'username' => $request->nim,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa',
        ]);

        Mahasiswa::create([
            'user_id' => $user->id,
            'nim' => $request->nim,
            'nama_mahasiswa' => $request->nama_mahasiswa,
            'prodi' => $request->prodi,
            'no_hp' => $request->no_hp,
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'Registrasi berhasil! Selamat datang.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
