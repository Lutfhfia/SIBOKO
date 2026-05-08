@extends('layouts.app')

@section('title', 'Detail Dosen')
@section('page-title', 'Detail Dosen')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="form-card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-person-badge me-2"></i>{{ $dosen->nama_dosen }}</h5>
                <a href="{{ route('dosen.index') }}" class="btn btn-sm btn-light"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr><th style="width:180px;">Nama Dosen</th><td>{{ $dosen->nama_dosen }}</td></tr>
                    <tr><th>NIDN</th><td>{{ $dosen->nidn }}</td></tr>
                    <tr><th>Bidang Keahlian</th><td>{{ $dosen->bidang_keahlian }}</td></tr>
                    <tr><th>Email</th><td>{{ $dosen->email ?? '-' }}</td></tr>
                    <tr><th>No HP</th><td>{{ $dosen->no_hp ?? '-' }}</td></tr>
                </table>
            </div>
        </div>

        {{-- Jadwal Dosen --}}
        <div class="table-card mb-4">
            <div class="card-header"><i class="bi bi-clock me-2"></i>Jadwal Konsultasi</div>
            <div class="table-responsive">
                <table class="table">
                    <thead><tr><th>Hari</th><th>Jam Mulai</th><th>Jam Selesai</th><th>Kuota</th><th>Keterangan</th></tr></thead>
                    <tbody>
                        @forelse($dosen->jadwals as $jadwal)
                        <tr>
                            <td>{{ $jadwal->hari }}</td>
                            <td>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}</td>
                            <td>{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td>
                            <td>{{ $jadwal->kuota }}</td>
                            <td>{{ $jadwal->keterangan ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-3">Belum ada jadwal.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Booking Dosen --}}
        <div class="table-card">
            <div class="card-header"><i class="bi bi-journal-bookmark me-2"></i>Booking Konsultasi</div>
            <div class="table-responsive">
                <table class="table">
                    <thead><tr><th>Mahasiswa</th><th>NIM</th><th>Tanggal</th><th>Jam</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse($dosen->bookings as $b)
                        <tr>
                            <td>{{ $b->nama_mahasiswa }}</td>
                            <td>{{ $b->nim }}</td>
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
                        <tr><td colspan="5" class="text-center text-muted py-3">Belum ada booking.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
