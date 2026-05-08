<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Menampilkan daftar semua booking.
     */
    public function index()
    {
        $bookings = Booking::with('dosen')->latest()->get();
        return view('booking.index', compact('bookings'));
    }

    /**
     * Menampilkan form tambah booking.
     */
    public function create()
    {
        $dosens = Dosen::orderBy('nama_dosen')->get();
        return view('booking.create', compact('dosens'));
    }

    /**
     * Menyimpan booking baru dengan validasi bentrok jadwal.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
            'nama_mahasiswa' => 'required|string|max:100',
            'nim' => 'required|string|max:30',
            'prodi' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'jam' => 'required|date_format:H:i',
            'topik' => 'required|string',
        ]);

        // Validasi bentrok jadwal
        $bentrok = Booking::where('dosen_id', $request->dosen_id)
            ->where('tanggal', $request->tanggal)
            ->where('jam', $request->jam)
            ->whereIn('status', ['Menunggu', 'Disetujui'])
            ->exists();

        if ($bentrok) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jadwal konsultasi sudah dibooking oleh mahasiswa lain. Silakan pilih waktu yang berbeda.');
        }

        Booking::create($request->all());

        return redirect()->route('booking.index')->with('success', 'Booking konsultasi berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail booking.
     */
    public function show(Booking $booking)
    {
        $booking->load('dosen');
        return view('booking.show', compact('booking'));
    }

    /**
     * Menampilkan form edit booking.
     */
    public function edit(Booking $booking)
    {
        $dosens = Dosen::orderBy('nama_dosen')->get();
        return view('booking.edit', compact('booking', 'dosens'));
    }

    /**
     * Mengupdate data booking.
     */
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
            'nama_mahasiswa' => 'required|string|max:100',
            'nim' => 'required|string|max:30',
            'prodi' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'jam' => 'required|date_format:H:i',
            'topik' => 'required|string',
            'status' => 'required|in:Menunggu,Disetujui,Ditolak,Selesai',
        ]);

        // Validasi bentrok (kecuali booking ini sendiri)
        $bentrok = Booking::where('dosen_id', $request->dosen_id)
            ->where('tanggal', $request->tanggal)
            ->where('jam', $request->jam)
            ->whereIn('status', ['Menunggu', 'Disetujui'])
            ->where('id', '!=', $booking->id)
            ->exists();

        if ($bentrok) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jadwal konsultasi sudah dibooking oleh mahasiswa lain. Silakan pilih waktu yang berbeda.');
        }

        $booking->update($request->all());

        return redirect()->route('booking.index')->with('success', 'Booking konsultasi berhasil diperbarui!');
    }

    /**
     * Mengubah status booking.
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Disetujui,Ditolak,Selesai',
        ]);

        $booking->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status booking berhasil diubah menjadi ' . $request->status . '!');
    }

    /**
     * Menghapus booking.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('booking.index')->with('success', 'Booking konsultasi berhasil dihapus!');
    }

    /**
     * Menampilkan laporan booking dengan filter.
     */
    public function laporan(Request $request)
    {
        $query = Booking::with('dosen');

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan dosen
        if ($request->filled('dosen_id')) {
            $query->where('dosen_id', $request->dosen_id);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal', '<=', $request->tanggal_sampai);
        }

        $bookings = $query->latest()->get();
        $dosens = Dosen::orderBy('nama_dosen')->get();

        return view('laporan.booking', compact('bookings', 'dosens'));
    }

    /**
     * Unduh laporan booking dalam format PDF.
     */
    public function unduhLaporan(Request $request)
{
    $query = Booking::with('dosen');

    // Filter berdasarkan status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Filter berdasarkan bulan
    if ($request->filled('bulan')) {
        $query->whereMonth('tanggal', $request->bulan);
    }

    // Filter berdasarkan program studi
    if ($request->filled('prodi')) {
        $query->where('prodi', $request->prodi);
    }

    $bookings = $query->latest()->get();

    $bulan = $request->filled('bulan')
        ? \Carbon\Carbon::create()->month((int) $request->bulan)->translatedFormat('F')
        : 'Semua Bulan';

    $prodi = $request->filled('prodi')
        ? $request->prodi
        : 'Semua Program Studi';

    $status = $request->filled('status')
        ? $request->status
        : 'Semua Status';

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan.pdf_booking', compact('bookings', 'bulan', 'prodi', 'status'))
        ->setPaper('a4', 'portrait');

    $fileName = 'Laporan_Booking_SIBOKO.pdf';

    return response($pdf->output(), 200)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"')
        ->header('Cache-Control', 'private, max-age=0, must-revalidate')
        ->header('Pragma', 'public');
}
}
