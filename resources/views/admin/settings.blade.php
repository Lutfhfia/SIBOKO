@extends('layouts.app')

@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan Sistem')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius:15px;">
    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
        <h5 class="fw-bold"><i class="bi bi-gear-fill me-2 text-primary"></i>Data Ketua Jurusan</h5>
        <p class="text-muted mb-0">Data ini akan tampil pada tanda tangan Lembar Bimbingan PDF.</p>
    </div>
    <div class="card-body p-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-4">
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Nama Ketua Jurusan <span class="text-danger">*</span></label>
                    <input type="text" name="ketua_jurusan_nama" class="form-control" value="{{ old('ketua_jurusan_nama', $ketuaNama) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">NIP <span class="text-danger">*</span></label>
                    <input type="text" name="ketua_jurusan_nip" class="form-control" value="{{ old('ketua_jurusan_nip', $ketuaNip) }}" required>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan Pengaturan</button>
            </div>
        </form>
    </div>
</div>
@endsection
