@extends('layouts.mahasiswa')

@section('title', 'Jadwal Konsultasi')

@section('content')
<section class="py-5">
    <div class="container py-3">
        <div class="text-center mb-5">
            <h2 class="section-title">Jadwal Konsultasi Dosen</h2>
            <p class="section-subtitle">Pilih dosen dan waktu yang sesuai untuk konsultasi</p>
        </div>

        @forelse($dosens as $dosen)
        <div class="jadwal-dosen-card mb-4">
            <div class="dosen-header">
                <h5><i class="bi bi-person-badge me-2"></i>{{ $dosen->nama_dosen }}</h5>
                <small><i class="bi bi-bookmark me-1"></i>{{ $dosen->bidang_keahlian }}</small>
            </div>
            @if($dosen->jadwals->count() > 0)
                @foreach($dosen->jadwals as $jadwal)
                <div class="jadwal-item">
                    <div class="jadwal-info">
                        <div class="jadwal-hari"><i class="bi bi-calendar3 me-2"></i>{{ $jadwal->hari }}</div>
                        <div class="jadwal-jam">
                            <i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} — {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                            @if($jadwal->keterangan)
                                <span class="ms-2 text-muted">• {{ $jadwal->keterangan }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="text-end me-2">
                            <span class="jadwal-kuota d-block">Total Kuota: {{ $jadwal->kuota }}</span>
                            <small class="text-{{ $jadwal->sisa_kuota == 0 ? 'danger fw-bold' : 'success' }}">Sisa Kuota (Tgl {{ $jadwal->tanggal_terdekat }}): {{ $jadwal->sisa_kuota }}</small>
                        </div>
                        @if($jadwal->sisa_kuota > 0)
                            @auth
                                <a href="javascript:void(0)" onclick="openBookingModal('{{ $dosen->id }}')" class="btn btn-sm btn-primary">Booking</a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-sm btn-primary">Booking</a>
                            @endauth
                        @else
                            <button class="btn btn-sm btn-secondary" disabled>Penuh</button>
                        @endif
                    </div>
                </div>
                @endforeach
            @else
                <div class="p-4 text-center text-muted">
                    <i class="bi bi-info-circle me-1"></i> Belum ada jadwal untuk dosen ini.
                </div>
            @endif
        </div>
        @empty
        <div class="text-center py-5 text-muted">
            <i class="bi bi-calendar-x" style="font-size:3rem;"></i>
            <p class="mt-3">Belum ada data dosen dan jadwal konsultasi.</p>
        </div>
        @endforelse
    </div>
</section>
@endsection
