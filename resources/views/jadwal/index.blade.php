@extends('layouts.app')

@section('title', 'Jadwal Konsultasi')
@section('page-title', 'Jadwal Konsultasi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Jadwal Konsultasi</h4>
        <p class="text-muted mb-0">Kelola jadwal konsultasi dosen</p>
    </div>
    <a href="{{ route('jadwal.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Jadwal
    </a>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Dosen</th>
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
                    <td><strong>{{ $jadwal->dosen->nama_dosen ?? '-' }}</strong></td>
                    <td>{{ $jadwal->hari }}</td>
                    <td>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td>
                    <td>{{ $jadwal->kuota }}</td>
                    <td>{{ Str::limit($jadwal->keterangan, 30) ?? '-' }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('jadwal.show', $jadwal) }}" class="btn-action btn btn-info text-white" title="Detail"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('jadwal.edit', $jadwal) }}" class="btn-action btn btn-warning text-white" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('jadwal.destroy', $jadwal) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action btn btn-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">Belum ada jadwal konsultasi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
