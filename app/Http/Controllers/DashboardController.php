<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Jadwal;
use App\Models\Booking;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard dengan ringkasan data.
     */
    public function index()
    {
        $totalDosen = Dosen::count();
        $totalMahasiswa = Mahasiswa::count();
        $totalJadwal = Jadwal::count();
        $totalBooking = Booking::count();
        $totalMenunggu = Booking::where('status', 'Menunggu')->count();
        $totalDisetujui = Booking::where('status', 'Disetujui')->count();
        $totalDitolak = Booking::where('status', 'Ditolak')->count();
        $totalSelesai = Booking::where('status', 'Selesai')->count();

        $bookingTerbaru = Booking::with(['dosen', 'mahasiswa'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalDosen',
            'totalMahasiswa',
            'totalJadwal',
            'totalBooking',
            'totalMenunggu',
            'totalDisetujui',
            'totalDitolak',
            'totalSelesai',
            'bookingTerbaru'
        ));
    }
}
