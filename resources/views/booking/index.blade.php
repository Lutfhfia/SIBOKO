@extends('layouts.app')

@section('title', 'Booking Konsultasi')
@section('page-title', 'Booking Konsultasi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Booking Konsultasi</h4>
        <p class="text-muted mb-0">Kelola semua booking konsultasi mahasiswa</p>
    </div>
    <a href="{{ route('booking.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Booking
    </a>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Mahasiswa</th>
                    <th>NIM</th>
                    <th>Dosen</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Topik</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $i => $b)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><strong>{{ $b->nama_mahasiswa }}</strong></td>
                    <td>{{ $b->nim }}</td>
                    <td>{{ $b->dosen->nama_dosen ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($b->tanggal)->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($b->jam)->format('H:i') }}</td>
                    <td>{{ Str::limit($b->topik, 25) }}</td>
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
                    <td>
                        <div class="d-flex gap-1 flex-wrap">
                            {{-- Status Buttons --}}
                            @if($b->status == 'Menunggu')
                                <form action="{{ route('booking.updateStatus', $b) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="Disetujui">
                                    <button type="submit" class="btn-action btn btn-success" title="Setujui"><i class="bi bi-check-lg"></i></button>
                                </form>
                                <form action="{{ route('booking.updateStatus', $b) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="Ditolak">
                                    <button type="submit" class="btn-action btn btn-danger" title="Tolak"><i class="bi bi-x-lg"></i></button>
                                </form>
                            @elseif($b->status == 'Disetujui')
                                <form action="{{ route('booking.updateStatus', $b) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="Selesai">
                                    <button type="submit" class="btn-action btn btn-info text-white" title="Selesai"><i class="bi bi-check-circle"></i></button>
                                </form>
                            @endif

                            <a href="{{ route('booking.show', $b) }}" class="btn-action btn btn-outline-primary" title="Detail"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('booking.edit', $b) }}" class="btn-action btn btn-outline-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('booking.destroy', $b) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus booking ini?')" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action btn btn-outline-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center text-muted py-4">Belum ada data booking.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
