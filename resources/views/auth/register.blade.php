@extends('layouts.mahasiswa')

@section('title', 'Daftar Akun Mahasiswa')

@section('content')
<div class="container py-5" style="min-height: 80vh; display: flex; align-items: center;">
    <div class="row w-100 justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0" style="border-radius: 20px;">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-person-plus text-primary mb-3" style="font-size: 3rem;"></i>
                        <h4 class="fw-bold">Daftar Akun Mahasiswa</h4>
                        <p class="text-muted">Buat akun untuk mengajukan jadwal bimbingan.</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger" style="border-radius: 10px;">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">NIM <span class="text-danger">*</span></label>
                                <input type="text" name="nim" class="form-control" value="{{ old('nim') }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama_mahasiswa" class="form-control" value="{{ old('nama_mahasiswa') }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Nomor HP <span class="text-danger">*</span></label>
                                <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}" placeholder="Contoh: 081234567890" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Program Studi <span class="text-danger">*</span></label>
                                <select name="prodi" class="form-select" required>
                                    <option value="">-- Pilih Program Studi --</option>
                                    <option value="D3 Manajemen Informatika" {{ old('prodi') == 'D3 Manajemen Informatika' ? 'selected' : '' }}>D3 Manajemen Informatika</option>
                                    <option value="D4 Manajemen Informatika" {{ old('prodi') == 'D4 Manajemen Informatika' ? 'selected' : '' }}>D4 Manajemen Informatika</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Konfirmasi Password <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary btn-lg w-100" style="border-radius: 10px;">Daftar Akun</button>
                            </div>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <p class="mb-0 text-muted">Sudah punya akun? <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">Masuk di sini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
