@extends('layouts.mahasiswa')

@section('title', 'Riwayat Bimbingan')

@section('content')
<div class="container py-5" style="min-height: 70vh;">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <h3 class="fw-bold mb-0"><i class="bi bi-clock-history me-2 text-primary"></i>Riwayat Bimbingan Saya</h3>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('mahasiswa.jadwal') }}" class="btn btn-primary rounded-pill px-4">
                <i class="bi bi-journal-plus me-1"></i> Ajukan Bimbingan
            </a>
            @php $mhs = auth()->user()->mahasiswa; @endphp
            @if($bookings->count() > 0)
                @if($mhs->pembimbing1_id)
                <a href="{{ route('mahasiswa.riwayat.unduh', ['dosen_id' => $mhs->pembimbing1_id]) }}" class="btn btn-outline-danger rounded-pill px-3">
                    <i class="bi bi-file-earmark-pdf me-1"></i> PDF Pembimbing I
                </a>
                @endif
                @if($mhs->pembimbing2_id)
                <a href="{{ route('mahasiswa.riwayat.unduh', ['dosen_id' => $mhs->pembimbing2_id]) }}" class="btn btn-outline-danger rounded-pill px-3">
                    <i class="bi bi-file-earmark-pdf me-1"></i> PDF Pembimbing II
                </a>
                @endif
            @endif
        </div>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 15px; overflow:hidden;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Dosen</th>
                        <th>Subject</th>
                        <th>Tanggal</th>
                        <th>Presensi</th>
                        <th>Status</th>
                        <th>Uraian</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $i => $b)
                        <tr>
                            <td class="ps-4">{{ $i + 1 }}</td>
                            <td>
                                <strong>{{ $b->dosen->nama_dosen }}</strong><br>
                                <small class="text-muted">{{ $b->dosen->bidang_keahlian }}</small>
                            </td>
                            <td><span class="badge bg-light text-dark border">{{ $b->subject ?? '-' }}</span></td>
                            <td>
                                {{ \Carbon\Carbon::parse($b->tanggal)->format('d/m/Y') }}<br>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($b->jam)->format('H:i') }}</small>
                            </td>
                            <td>
                                @if($b->presensi === 'Hadir')
                                    <span class="badge bg-success">Hadir</span>
                                @elseif($b->presensi === 'Tidak Hadir')
                                    <span class="badge bg-danger">Tidak Hadir</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($b->status == 'Menunggu')
                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2">Menunggu</span>
                                @elseif($b->status == 'Disetujui')
                                    <span class="badge bg-success rounded-pill px-3 py-2">Disetujui</span>
                                @elseif($b->status == 'Revisi')
                                    <span class="badge bg-warning rounded-pill px-3 py-2">Revisi</span>
                                @elseif($b->status == 'Ditolak')
                                    <span class="badge bg-danger rounded-pill px-3 py-2">Ditolak</span>
                                @elseif($b->status == 'Selesai')
                                    <span class="badge bg-info text-dark rounded-pill px-3 py-2">Selesai</span>
                                @endif
                            </td>
                            <td>
                                @if($b->uraian)
                                    <small class="fst-italic">{{ Str::limit($b->uraian, 40) }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-journal-x text-muted mb-3 d-block" style="font-size: 3rem;"></i>
                                <h5 class="text-muted">Belum ada riwayat bimbingan</h5>
                                <p class="text-muted mb-4">Anda belum pernah mengajukan jadwal bimbingan dengan dosen manapun.</p>
                                <a href="{{ route('mahasiswa.jadwal') }}" class="btn btn-outline-primary rounded-pill px-4">Mulai Ajukan Bimbingan</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
