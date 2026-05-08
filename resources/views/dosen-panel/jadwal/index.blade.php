@extends('layouts.dosen')

@section('title', 'Jadwal Bimbingan')
@section('page-title', 'Buka Jadwal Bimbingan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Jadwal Bimbingan Saya</h4>
        <p class="text-muted mb-0">Kelola waktu luang Anda untuk bimbingan mahasiswa</p>
    </div>
    <a href="{{ route('dosen-panel.jadwal.create') }}" class="btn" style="background-color: #0f766e; color: white;">
        <i class="bi bi-plus-lg me-1"></i> Buka Bimbingan Baru
    </a>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Hari</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th>Kuota</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwals as $i => $jadwal)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><span class="badge bg-light text-dark border">{{ $jadwal->hari }}</span></td>
                    <td><i class="bi bi-clock me-1 text-muted"></i>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}</td>
                    <td><i class="bi bi-clock me-1 text-muted"></i>{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td>
                    <td><span class="badge bg-info text-dark rounded-pill px-3">{{ $jadwal->kuota }} Mhs</span></td>
                    <td>{{ Str::limit($jadwal->keterangan, 30) ?? '-' }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('dosen-panel.jadwal.edit', $jadwal) }}" class="btn-action btn btn-warning text-white" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('dosen-panel.jadwal.destroy', $jadwal) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action btn btn-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-5"><i class="bi bi-calendar-x fs-1 d-block mb-3"></i>Anda belum membuka jadwal bimbingan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
