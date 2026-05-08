@extends('layouts.app')

@section('title', 'Laporan Booking')
@section('page-title', 'Laporan Booking')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold mb-1">Laporan Booking Konsultasi</h4>
    <p class="text-muted mb-0">Filter dan cetak laporan data booking</p>
</div>

{{-- Filter --}}
<div class="form-card mb-4 no-print">
    <div class="card-header">
        <h6 class="mb-0"><i class="bi bi-funnel me-2"></i>Filter Laporan</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('booking.laporan') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        @foreach(['Menunggu','Disetujui','Ditolak','Selesai'] as $s)
                            <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Bulan</label>
                    <select name="bulan" class="form-select">
                        <option value="">Semua Bulan</option>
                        @for($m=1; $m<=12; $m++)
                            <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Program Studi</label>
                    <select name="prodi" class="form-select">
                        <option value="">Semua Program Studi</option>
                        <option value="D3 Manajemen Informatika" {{ request('prodi') == 'D3 Manajemen Informatika' ? 'selected' : '' }}>D3 Manajemen Informatika</option>
                        <option value="D4 Manajemen Informatika" {{ request('prodi') == 'D4 Manajemen Informatika' ? 'selected' : '' }}>D4 Manajemen Informatika</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-search me-1"></i> Filter</button>
                    <a href="{{ route('booking.laporan') }}" class="btn btn-outline-secondary" title="Reset"><i class="bi bi-arrow-counterclockwise"></i></a>
                    <button type="submit" formaction="{{ route('booking.laporan.unduh') }}" formtarget="_blank" class="btn btn-outline-danger ms-auto">
                        <i class="bi bi-file-earmark-pdf me-1"></i> Unduh PDF
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Info Total --}}
<div class="mb-3">
    <span class="text-muted">Total: <strong>{{ $bookings->count() }}</strong> data booking ditemukan</span>
</div>

{{-- Tabel Laporan --}}
<div class="table-card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Mahasiswa</th>
                    <th>NIM</th>
                    <th>Prodi</th>
                    <th>Dosen</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Topik</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $i => $b)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $b->nama_mahasiswa }}</td>
                    <td>{{ $b->nim }}</td>
                    <td>{{ $b->prodi }}</td>
                    <td>{{ $b->dosen->nama_dosen ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($b->tanggal)->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($b->jam)->format('H:i') }}</td>
                    <td>{{ Str::limit($b->topik, 30) }}</td>
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
                <tr><td colspan="9" class="text-center text-muted py-4">Tidak ada data booking sesuai filter.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
