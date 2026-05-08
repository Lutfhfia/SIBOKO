@extends('layouts.dosen')

@section('title', 'Dashboard Dosen')
@section('page-title', 'Dashboard Dosen')

@section('content')
<div class="row g-4 mb-4">
    {{-- Total Jadwal Saya --}}
    <div class="col-md-4">
        <div class="stat-card" style="border-left: 5px solid #0f766e;">
            <div class="stat-icon" style="background: rgba(15, 118, 110, 0.1); color: #0f766e;"><i class="bi bi-clock-fill"></i></div>
            <div class="stat-value">{{ $totalJadwal }}</div>
            <div class="stat-label">Jadwal Dibuka</div>
        </div>
    </div>
    {{-- Total Booking --}}
    <div class="col-md-4">
        <div class="stat-card" style="border-left: 5px solid #3b82f6;">
            <div class="stat-icon" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;"><i class="bi bi-journal-bookmark-fill"></i></div>
            <div class="stat-value">{{ $totalBooking }}</div>
            <div class="stat-label">Total Booking Masuk</div>
        </div>
    </div>
    {{-- Menunggu --}}
    <div class="col-md-4">
        <div class="stat-card stat-warning">
            <div class="stat-icon"><i class="bi bi-hourglass-split"></i></div>
            <div class="stat-value">{{ $bookingMenunggu }}</div>
            <div class="stat-label">Menunggu Persetujuan</div>
        </div>
    </div>
</div>

{{-- Booking Terbaru --}}
<div class="table-card">
    <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom-0 pb-0">
        <span class="fw-bold"><i class="bi bi-clock-history me-2"></i>Booking Terbaru</span>
        <a href="{{ route('dosen-panel.booking.index') }}" class="btn btn-sm" style="background-color: #0f766e; color: white;">Lihat Semua</a>
    </div>
    <div class="table-responsive mt-2">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Mahasiswa</th>
                    <th>NIM</th>
                    <th>Topik</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookingTerbaru as $b)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @php $mhs = $b->mahasiswa; @endphp
                            @if($mhs && $mhs->foto_profil)
                                <img src="{{ asset('storage/' . $mhs->foto_profil) }}" alt="Foto" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                            @else
                                <div class="rounded-circle d-flex align-items-center justify-content-center bg-secondary text-white" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                    <i class="bi bi-person"></i>
                                </div>
                            @endif
                            <strong>{{ $b->nama_mahasiswa }}</strong>
                        </div>
                    </td>
                    <td>{{ $b->nim }}</td>
                    <td>{{ Str::limit($b->topik, 30) }}</td>
                    <td>{{ \Carbon\Carbon::parse($b->tanggal)->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($b->jam)->format('H:i') }}</td>
                    <td>
                        @if($b->status == 'Menunggu')
                            <span class="badge-menunggu">{{ $b->status }}</span>
                        @elseif($b->status == 'Disetujui')
                            <span class="badge-disetujui">{{ $b->status }}</span>
                        @elseif($b->status == 'Ditolak')
                            <span class="badge-ditolak">{{ $b->status }}</span>
                        @else
                            <span class="badge-selesai">{{ $b->status }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Belum ada data booking masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
