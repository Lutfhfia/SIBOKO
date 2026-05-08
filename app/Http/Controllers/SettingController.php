<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $ketuaNama = Setting::getValue('ketua_jurusan_nama');
        $ketuaNip = Setting::getValue('ketua_jurusan_nip');
        return view('admin.settings', compact('ketuaNama', 'ketuaNip'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'ketua_jurusan_nama' => 'required|string|max:200',
            'ketua_jurusan_nip' => 'required|string|max:50',
        ]);

        Setting::updateOrCreate(['key' => 'ketua_jurusan_nama'], ['value' => $request->ketua_jurusan_nama]);
        Setting::updateOrCreate(['key' => 'ketua_jurusan_nip'], ['value' => $request->ketua_jurusan_nip]);

        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
