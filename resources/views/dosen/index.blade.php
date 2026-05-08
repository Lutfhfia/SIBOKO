@extends('layouts.app')

@section('title', 'Data Dosen')
@section('page-title', 'Data Dosen')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Daftar Dosen</h4>
        <p class="text-muted mb-0">Kelola data dosen yang tersedia untuk konsultasi</p>
    </div>
    <a href="{{ route('dosen.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Dosen
    </a>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Dosen</th>
                    <th>NIDN</th>
                    <th>Bidang Keahlian</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dosens as $i => $dosen)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><strong>{{ $dosen->nama_dosen }}</strong></td>
                    <td>{{ $dosen->nidn }}</td>
                    <td>{{ $dosen->bidang_keahlian }}</td>
                    <td>{{ $dosen->email ?? '-' }}</td>
                    <td>{{ $dosen->no_hp ?? '-' }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('dosen.show', $dosen) }}" class="btn-action btn btn-info text-white" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('dosen.edit', $dosen) }}" class="btn-action btn btn-warning text-white" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('dosen.destroy', $dosen) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data dosen ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action btn btn-danger" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">Belum ada data dosen.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
