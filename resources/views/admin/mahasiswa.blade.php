@extends('layouts.app')

@section('title', 'Data Mahasiswa')
@section('page-title', 'Data Mahasiswa Terdaftar')

@section('content')
<div class="table-card">
    <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom-0 pb-0">
        <span class="fw-bold"><i class="bi bi-people-fill me-2"></i>Daftar Mahasiswa ({{ $mahasiswas->count() }})</span>
        <a href="{{ route('admin.mahasiswa.create') }}" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg me-1"></i>Tambah Mahasiswa</a>
    </div>
    <div class="table-responsive mt-2">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Mahasiswa</th>
                    <th>NIM</th>
                    <th>Program Studi</th>
                    <th>Pembimbing I</th>
                    <th>Pembimbing II</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mahasiswas as $i => $m)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            @if($m->foto_profil)
                                <img src="{{ asset('storage/' . $m->foto_profil) }}" alt="Foto" class="rounded-circle" 
                                     style="width: 40px; height: 40px; object-fit: cover; cursor: pointer;"
                                     onclick="showImageModal(this.src, '{{ $m->nama_mahasiswa }}')">
                            @else
                                <div class="rounded-circle d-flex align-items-center justify-content-center bg-secondary text-white" style="width: 40px; height: 40px;">
                                    <i class="bi bi-person"></i>
                                </div>
                            @endif
                            <strong>{{ $m->nama_mahasiswa }}</strong>
                        </div>
                    </td>
                    <td>{{ $m->nim }}</td>
                    <td>{{ $m->prodi }}</td>
                    <td><small>@if($m->pembimbing1) {{ $m->pembimbing1->nama_dosen }} @else <span class="text-danger">Belum</span> @endif</small></td>
                    <td><small>@if($m->pembimbing2) {{ $m->pembimbing2->nama_dosen }} @else <span class="text-danger">Belum</span> @endif</small></td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.mahasiswa.edit', $m->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil-square"></i></a>
                            <form action="{{ route('admin.mahasiswa.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus mahasiswa ini?');" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">Belum ada mahasiswa terdaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Image Preview Modal --}}
<div class="modal fade" id="imagePreviewModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0" style="background: transparent;">
            <div class="modal-body text-center p-0">
                <img id="imagePreviewImg" src="" alt="" style="max-width: 100%; max-height: 80vh; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.5);">
                <p class="text-white mt-3 fw-semibold" id="imagePreviewName"></p>
            </div>
        </div>
    </div>
</div>

<script>
function showImageModal(src, name) {
    document.getElementById('imagePreviewImg').src = src;
    document.getElementById('imagePreviewName').textContent = name;
    new bootstrap.Modal(document.getElementById('imagePreviewModal')).show();
}
</script>
@endsection
