@extends('layouts.app')

@section('title', 'Tambah Dosen')
@section('page-title', 'Tambah Dosen')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="form-card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-person-plus-fill me-2"></i>Form Tambah Dosen</h5>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger" style="border-radius:10px; border:none; background:rgba(239,68,68,0.1); color:#b91c1c;">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('dosen.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Dosen <span class="text-danger">*</span></label>
                            <input type="text" name="nama_dosen" class="form-control" value="{{ old('nama_dosen') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">NIDN <span class="text-danger">*</span></label>
                            <input type="text" name="nidn" class="form-control" value="{{ old('nidn') }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Bidang Keahlian <span class="text-danger">*</span></label>
                            <input type="text" name="bidang_keahlian" class="form-control" value="{{ old('bidang_keahlian') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">No HP</label>
                            <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}">
                        </div>
                        <div class="col-12 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i> Simpan
                            </button>
                            <a href="{{ route('dosen.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
