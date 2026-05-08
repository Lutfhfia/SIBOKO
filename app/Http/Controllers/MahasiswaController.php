<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Jadwal;
use App\Models\Booking;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MahasiswaController extends Controller
{
    /**
     * Daftar subject bimbingan (urutan tetap).
     */
    public const SUBJECTS = [
        1 => 'Pengajuan Judul',
        2 => 'Surat Permintaan Data ke Industri',
        3 => 'Bab I',
        4 => 'Bab II',
        5 => 'Bab III',
        6 => 'Perancangan Aplikasi',
        7 => 'Implementasi Aplikasi',
        8 => 'Pengujian Sistem',
        9 => 'Bab IV',
        10 => 'Bab V',
        11 => 'Finalisasi Laporan',
        12 => 'Surat Rekomendasi Ujikom',
    ];

    /**
     * Halaman beranda publik.
     */
    public function beranda()
    {
        $totalDosen = Dosen::count();
        $totalJadwal = Jadwal::count();
        return view('mahasiswa.beranda', compact('totalDosen', 'totalJadwal'));
    }

    /**
     * Menampilkan jadwal konsultasi semua dosen.
     */
    public function jadwal()
    {
        $mahasiswa = Auth::user()->mahasiswa;
        $pembimbingIds = array_filter([$mahasiswa->pembimbing1_id, $mahasiswa->pembimbing2_id]);

        $dosens = \App\Models\Dosen::with('jadwals')
            ->whereIn('id', $pembimbingIds)
            ->orderBy('nama_dosen')
            ->get();
        
        $hariNameEng = [
            'Senin' => 'Monday', 'Selasa' => 'Tuesday', 'Rabu' => 'Wednesday',
            'Kamis' => 'Thursday', 'Jumat' => 'Friday', 'Sabtu' => 'Saturday', 'Minggu' => 'Sunday'
        ];

        // Hitung sisa kuota untuk tanggal terdekat untuk setiap jadwal
        foreach ($dosens as $dosen) {
            foreach ($dosen->jadwals as $jadwal) {
                $engDay = $hariNameEng[$jadwal->hari] ?? 'Monday';
                $today = \Carbon\Carbon::now();
                
                // Jika hari ini adalah hari jadwal, gunakan hari ini. Jika tidak, cari hari berikutnya.
                if ($today->format('l') === $engDay) {
                    $nextDate = $today->format('Y-m-d');
                } else {
                    $nextDate = \Carbon\Carbon::parse("next $engDay")->format('Y-m-d');
                }
                
                // Hitung SEMUA booking di tanggal tersebut untuk dosen ini (dalam rentang jam jadwal)
                $booked = \App\Models\Booking::where('dosen_id', $dosen->id)
                    ->where('tanggal', $nextDate)
                    ->where('jam', '>=', $jadwal->jam_mulai)
                    ->where('jam', '<=', $jadwal->jam_selesai)
                    ->whereIn('status', ['Menunggu', 'Disetujui'])
                    ->count();
                
                $jadwal->sisa_kuota = max(0, $jadwal->kuota - $booked);
                $jadwal->tanggal_terdekat = \Carbon\Carbon::parse($nextDate)->format('d/m/Y');
            }
        }

        return view('mahasiswa.jadwal', compact('dosens'));
    }

    /**
     * Menyimpan booking dari mahasiswa.
     */
    public function bookingStore(Request $request)
    {
        $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
            'tanggal' => 'required|date',
            'jam' => 'required|date_format:H:i',
            'topik' => 'required|string',
            'subject' => 'required|string',
        ]);

        $mahasiswa = Auth::user()->mahasiswa;
        $mahasiswaId = $mahasiswa->id;

        // 0. Cek Judul TA harus sudah diisi
        if (empty($mahasiswa->judul_ta)) {
            return response()->json([
                'success' => false,
                'message' => 'Anda harus mengisi Judul Laporan Akhir/Tugas Akhir di halaman Profil terlebih dahulu sebelum booking bimbingan.'
            ], 422);
        }

        // 0b. Cek pembimbing harus sudah di-assign
        if (!$mahasiswa->pembimbing1_id && !$mahasiswa->pembimbing2_id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum memiliki pembimbing. Hubungi Admin untuk penugasan pembimbing.'
            ], 422);
        }

        // 0c. Cek dosen yang dipilih harus salah satu pembimbing
        if ($request->dosen_id != $mahasiswa->pembimbing1_id && $request->dosen_id != $mahasiswa->pembimbing2_id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda hanya bisa booking bimbingan dengan dosen pembimbing Anda.'
            ], 422);
        }

        $tanggal = Carbon::parse($request->tanggal);
        $hariNameIndo = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];
        $hariReq = $hariNameIndo[$tanggal->format('l')];

        // 1. Cek apakah Dosen buka jadwal di hari tersebut & jam tersebut ada di rentang
        $jadwalDosen = Jadwal::where('dosen_id', $request->dosen_id)
            ->where('hari', $hariReq)
            ->where('jam_mulai', '<=', $request->jam)
            ->where('jam_selesai', '>=', $request->jam)
            ->first();

        if (!$jadwalDosen) {
            return response()->json([
                'success' => false,
                'message' => "Dosen tidak membuka jadwal bimbingan pada hari $hariReq di jam {$request->jam}. Silakan periksa kembali jadwal dosen."
            ], 422);
        }

        // 2. Cek Kuota di tanggal tersebut
        $jumlahBookingHariIni = Booking::where('dosen_id', $request->dosen_id)
            ->where('tanggal', $request->tanggal)
            ->whereIn('status', ['Menunggu', 'Disetujui'])
            ->count();

        if ($jumlahBookingHariIni >= $jadwalDosen->kuota) {
            return response()->json([
                'success' => false,
                'message' => "Kuota bimbingan dosen pada tanggal tersebut sudah penuh. Silakan pilih tanggal lain."
            ], 422);
        }

        // 3. Cek Bentrok Mahasiswa Lain di Jam yang Sama
        $bentrok = Booking::where('dosen_id', $request->dosen_id)
            ->where('tanggal', $request->tanggal)
            ->where('jam', $request->jam)
            ->whereIn('status', ['Menunggu', 'Disetujui'])
            ->exists();

        if ($bentrok) {
            return response()->json([
                'success' => false,
                'message' => 'Jam konsultasi tersebut sudah dibooking oleh mahasiswa lain. Silakan pilih waktu yang berbeda.'
            ], 422);
        }

        // 4. Cek Bentrok Jadwal Mahasiswa Sendiri
        $bentrokSendiri = Booking::where('mahasiswa_id', $mahasiswaId)
            ->where('tanggal', $request->tanggal)
            ->where('jam', $request->jam)
            ->whereIn('status', ['Menunggu', 'Disetujui'])
            ->exists();

        if ($bentrokSendiri) {
             return response()->json([
                'success' => false,
                'message' => 'Anda sudah memiliki jadwal bimbingan di waktu yang sama dengan dosen lain.'
            ], 422);
        }

        // 5. Cek Batasan Maks 2 bimbingan per hari
        $bookingHariIniMhs = Booking::where('mahasiswa_id', $mahasiswaId)
            ->where('tanggal', $request->tanggal)
            ->whereIn('status', ['Menunggu', 'Disetujui'])
            ->count();

        if ($bookingHariIniMhs >= 2) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah memiliki 2 booking bimbingan di tanggal ini. Maksimal 2 bimbingan per hari.'
            ], 422);
        }

        Booking::create([
            'dosen_id' => $request->dosen_id,
            'mahasiswa_id' => $mahasiswaId,
            'nama_mahasiswa' => $mahasiswa->nama_mahasiswa,
            'nim' => $mahasiswa->nim,
            'prodi' => $mahasiswa->prodi,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'topik' => $request->topik,
            'subject' => $request->subject,
            'status' => 'Menunggu',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking konsultasi berhasil dikirim! Status awal: Menunggu. Silakan cek status booking secara berkala.'
        ]);
    }

    /**
     * Menampilkan hasil pencarian booking berdasarkan NIM via JSON (API).
     */
    public function hasilStatus($nim)
    {
        $bookings = Booking::with('dosen')
            ->where('nim', $nim)
            ->latest()
            ->get();

        if ($bookings->count() == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ditemukan booking untuk NIM tersebut.'
            ]);
        }

        $formattedBookings = $bookings->map(function($b) {
            return [
                'tanggal' => \Carbon\Carbon::parse($b->tanggal)->format('d M Y'),
                'jam' => \Carbon\Carbon::parse($b->jam)->format('H:i'),
                'dosen' => $b->dosen ? $b->dosen->nama_dosen : '-',
                'topik' => $b->topik,
                'status' => $b->status
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $formattedBookings
        ]);
    }

    public function profil()
    {
        $mahasiswa = Auth::user()->mahasiswa->load(['pembimbing1', 'pembimbing2']);
        return view('mahasiswa.profil', compact('mahasiswa'));
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'no_hp' => 'nullable|string|max:15',
            'judul_ta' => 'nullable|string|max:500',
        ]);

        $mahasiswa = Auth::user()->mahasiswa;

        if ($request->hasFile('foto_profil')) {
            $path = $request->file('foto_profil')->store('profil', 'public');
            $mahasiswa->foto_profil = $path;
        }

        if ($request->has('no_hp')) {
            $mahasiswa->no_hp = $request->no_hp;
        }

        if ($request->has('judul_ta')) {
            $mahasiswa->judul_ta = $request->judul_ta;
        }

        $mahasiswa->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Hitung subject berikutnya untuk mahasiswa terhadap dosen tertentu.
     */
    public static function getNextSubject($mahasiswaId, $dosenId)
    {
        $subjects = self::SUBJECTS;
        
        // Cek apakah ada subject yang statusnya Revisi (harus diulang)
        $revisiBooking = Booking::where('mahasiswa_id', $mahasiswaId)
            ->where('dosen_id', $dosenId)
            ->where('status', 'Revisi')
            ->latest()
            ->first();
        
        if ($revisiBooking) {
            return $revisiBooking->subject;
        }

        // Cek subject terakhir yang Selesai
        $completedSubjects = Booking::where('mahasiswa_id', $mahasiswaId)
            ->where('dosen_id', $dosenId)
            ->where('status', 'Selesai')
            ->pluck('subject')
            ->toArray();

        // Cari subject berikutnya yang belum selesai
        foreach ($subjects as $idx => $subj) {
            if (!in_array($subj, $completedSubjects)) {
                return $subj;
            }
        }

        return null; // Semua subject sudah selesai
    }

    public function riwayat()
    {
        $bookings = Booking::with('dosen')
            ->where('mahasiswa_id', Auth::user()->mahasiswa->id)
            ->latest()
            ->get();
        return view('mahasiswa.riwayat', compact('bookings'));
    }

    public function unduhRiwayat(Request $request)
    {
        $mahasiswa = Auth::user()->mahasiswa->load(['pembimbing1', 'pembimbing2']);
        $dosenId = $request->get('dosen_id');

        // Jika dosen_id tidak diberikan, default ke pembimbing 1
        if (!$dosenId) {
            $dosenId = $mahasiswa->pembimbing1_id;
        }

        $dosen = Dosen::find($dosenId);
        $pembimbingKe = ($dosenId == $mahasiswa->pembimbing1_id) ? 'I' : 'II';

        $bookings = Booking::with('dosen')
            ->where('mahasiswa_id', $mahasiswa->id)
            ->where('dosen_id', $dosenId)
            ->orderBy('tanggal', 'asc')
            ->get();

        $ketuaNama = Setting::getValue('ketua_jurusan_nama', 'Ir. Sony Oktapriandi, S.Kom.,M.Kom.');
        $ketuaNip = Setting::getValue('ketua_jurusan_nip', '197510272008121001');
            
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('mahasiswa.pdf_riwayat', compact(
            'bookings', 'mahasiswa', 'dosen', 'pembimbingKe', 'ketuaNama', 'ketuaNip'
        ));
        $pdf->setPaper('a4', 'portrait');
        
        $nama = str_replace(' ', '_', $mahasiswa->nama_mahasiswa ?? 'Mahasiswa');
        
        // Membersihkan output buffer untuk mencegah file PDF corrupted
        if (ob_get_length()) {
            ob_end_clean();
        }
        
        return $pdf->download("Lembar_Bimbingan_LA_{$nama}_Pembimbing_{$pembimbingKe}.pdf");
    }
}
