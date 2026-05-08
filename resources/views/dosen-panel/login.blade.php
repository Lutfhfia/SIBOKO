@extends('layouts.dosen')

@section('title', 'Masuk Panel Dosen')

@section('content')
<div class="container-fluid" style="background: #f8fafc; min-height: 100vh; display: flex; align-items: center; justify-content: center;">
    <div class="card shadow-sm border-0" style="width: 100%; max-width: 450px; border-radius: 15px;">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <i class="bi bi-calendar2-check text-teal" style="font-size: 3rem; color: #0d9488;"></i>
                <h4 class="fw-bold mt-2">Masuk Panel Dosen</h4>
                <p class="text-muted">Pilih nama Anda untuk mengelola jadwal bimbingan</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success" style="border-radius:10px; border: none; background: rgba(16,185,129,0.1); color: #047857;">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('dosen-panel.authenticate') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="form-label fw-semibold">Pilih Dosen <span class="text-danger">*</span></label>
                    <select name="dosen_id" class="form-select form-select-lg" required>
                        <option value="">-- Pilih Nama Anda --</option>
                        @foreach($dosens as $dosen)
                            <option value="{{ $dosen->id }}">{{ $dosen->nama_dosen }}</option>
                        @endforeach
                    </select>
                    @error('dosen_id')
                        <small class="text-danger mt-1">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-dosen btn-lg w-100" style="background-color: #0d9488; color: white;">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Masuk ke Panel
                </button>
            </form>
            
            <div class="text-center mt-4">
                <a href="{{ route('beranda') }}" class="text-decoration-none" style="color: #64748b;">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Halaman Utama
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
