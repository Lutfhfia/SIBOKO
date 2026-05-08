<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Jadwal;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenPanelController extends Controller
{
    /**
     * Halaman login / pilih dosen.
     */
    public function dashboard()
    {
        $dosenId = Auth::user()->dosen->id;
        
        $totalJadwal = Jadwal::where('dosen_id', $dosenId)->count();
        $totalBooking = Booking::where('dosen_id', $dosenId)->count();
        $bookingMenunggu = Booking::where('dosen_id', $dosenId)->where('status', 'Menunggu')->count();
        
        $bookingTerbaru = Booking::with('mahasiswa')->where('dosen_id', $dosenId)->latest()->take(5)->get();

        return view('dosen-panel.dashboard', compact('totalJadwal', 'totalBooking', 'bookingMenunggu', 'bookingTerbaru'));
    }

    /**
     * Jadwal Index.
     */
    public function jadwalIndex()
    {
        $jadwals = Jadwal::where('dosen_id', Auth::user()->dosen->id)->latest()->get();
        return view('dosen-panel.jadwal.index', compact('jadwals'));
    }

    /**
     * Jadwal Create.
     */
    public function jadwalCreate()
    {
        return view('dosen-panel.jadwal.create');
    }

    /**
     * Jadwal Store.
     */
    public function jadwalStore(Request $request)
    {
        $request->validate([
            'hari' => 'required|string',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i',
            'kuota' => 'required|integer|min:1',
            'keterangan' => 'nullable|string'
        ]);

        Jadwal::create([
            'dosen_id' => Auth::user()->dosen->id,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'kuota' => $request->kuota,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('dosen-panel.jadwal.index')->with('success', 'Jadwal bimbingan berhasil ditambahkan.');
    }

    /**
     * Jadwal Edit.
     */
    public function jadwalEdit(Jadwal $jadwal)
    {
        if ($jadwal->dosen_id != Auth::user()->dosen->id) abort(403);
        return view('dosen-panel.jadwal.edit', compact('jadwal'));
    }

    /**
     * Jadwal Update.
     */
    public function jadwalUpdate(Request $request, Jadwal $jadwal)
    {
        if ($jadwal->dosen_id != Auth::user()->dosen->id) abort(403);
        
        $request->validate([
            'hari' => 'required|string',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i',
            'kuota' => 'required|integer|min:1',
            'keterangan' => 'nullable|string'
        ]);

        $jadwal->update($request->all());

        return redirect()->route('dosen-panel.jadwal.index')->with('success', 'Jadwal bimbingan berhasil diperbarui.');
    }

    /**
     * Jadwal Destroy.
     */
    public function jadwalDestroy(Jadwal $jadwal)
    {
        if ($jadwal->dosen_id != Auth::user()->dosen->id) abort(403);
        $jadwal->delete();
        return redirect()->route('dosen-panel.jadwal.index')->with('success', 'Jadwal bimbingan berhasil dihapus.');
    }

    /**
     * Booking Index.
     */
    public function bookingIndex()
    {
        $bookings = Booking::with('mahasiswa')->where('dosen_id', Auth::user()->dosen->id)->latest()->get();
        return view('dosen-panel.booking.index', compact('bookings'));
    }

    /**
     * Booking Update Status.
     */
    public function bookingUpdateStatus(Request $request, Booking $booking)
    {
        if ($booking->dosen_id != Auth::user()->dosen->id) abort(403);
        
        $request->validate([
            'status' => 'required|in:Menunggu,Disetujui,Revisi,Ditolak,Selesai',
            'presensi' => 'required_if:status,Selesai|nullable|string|in:Hadir,Tidak Hadir',
            'uraian' => 'required_if:status,Selesai,Revisi|nullable|string',
        ]);

        $data = ['status' => $request->status];

        if (in_array($request->status, ['Selesai', 'Revisi'])) {
            $data['uraian'] = $request->uraian;
        }

        if ($request->status === 'Selesai') {
            $data['presensi'] = $request->presensi;
        }

        $booking->update($data);

        return redirect()->route('dosen-panel.booking.index')->with('success', 'Status booking berhasil diubah menjadi ' . $request->status);
    }
}
