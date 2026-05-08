@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    {{-- Total Dosen --}}
    <div class="col-md-6 col-lg-3">
        <div class="stat-card stat-primary">
            <div class="stat-icon"><i class="bi bi-person-badge-fill"></i></div>
            <div class="stat-value">{{ $totalDosen }}</div>
            <div class="stat-label">Total Dosen</div>
        </div>
    </div>
    {{-- Total Mahasiswa --}}
    <div class="col-md-6 col-lg-3">
        <div class="stat-card stat-info">
            <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
            <div class="stat-value">{{ $totalMahasiswa }}</div>
            <div class="stat-label">Total Mahasiswa</div>
        </div>
    </div>
    {{-- Total Booking --}}
    <div class="col-md-6 col-lg-3">
        <div class="stat-card stat-secondary">
            <div class="stat-icon"><i class="bi bi-journal-bookmark-fill"></i></div>
            <div class="stat-value">{{ $totalBooking }}</div>
            <div class="stat-label">Total Booking</div>
        </div>
    </div>
    {{-- Menunggu --}}
    <div class="col-md-6 col-lg-3">
        <div class="stat-card stat-warning">
            <div class="stat-icon"><i class="bi bi-hourglass-split"></i></div>
            <div class="stat-value">{{ $totalMenunggu }}</div>
            <div class="stat-label">Menunggu</div>
        </div>
    </div>
</div>

{{-- Booking Terbaru (Read Only) --}}
<div class="table-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-clock-history me-2"></i>Booking Terbaru (Semua Dosen)</span>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Mahasiswa</th>
                    <th>NIM</th>
                    <th>Dosen</th>
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
                    <td>{{ $b->dosen->nama_dosen ?? '-' }}</td>
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
                    <td colspan="6" class="text-center text-muted py-4">Belum ada data booking.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
