@extends('layouts.app')

@section('title', 'Edit Mahasiswa')
@section('page-title', 'Edit Data Mahasiswa')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius:15px;">
    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
        <h5 class="fw-bold"><i class="bi bi-pencil-square me-2 text-primary"></i>Form Edit Mahasiswa</h5>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('admin.mahasiswa.update', $mahasiswa->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Mahasiswa <span class="text-danger">*</span></label>
                    <input type="text" name="nama_mahasiswa" class="form-control @error('nama_mahasiswa') is-invalid @enderror" value="{{ old('nama_mahasiswa', $mahasiswa->nama_mahasiswa) }}" required>
                    @error('nama_mahasiswa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="col-md-6">
                    <label class="form-label fw-semibold">NIM (Username)</label>
                    <input type="text" class="form-control" value="{{ $mahasiswa->nim }}" disabled>
                    <small class="text-muted">NIM tidak dapat diubah.</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Program Studi <span class="text-danger">*</span></label>
                    <select name="prodi" class="form-select @error('prodi') is-invalid @enderror" required>
                        <option value="">-- Pilih Program Studi --</option>
                        <option value="D3 Manajemen Informatika" {{ old('prodi', $mahasiswa->prodi) == 'D3 Manajemen Informatika' ? 'selected' : '' }}>D3 Manajemen Informatika</option>
                        <option value="D4 Manajemen Informatika" {{ old('prodi', $mahasiswa->prodi) == 'D4 Manajemen Informatika' ? 'selected' : '' }}>D4 Manajemen Informatika</option>
                    </select>
                    @error('prodi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nomor HP</label>
                    <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp', $mahasiswa->no_hp) }}">
                    @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Password Baru</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Foto Profil Baru</label>
                    <div class="d-flex align-items-center gap-3">
                        @if($mahasiswa->foto_profil)
                            <img src="{{ asset('storage/' . $mahasiswa->foto_profil) }}" alt="Foto" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                        @endif
                        <div class="flex-grow-1">
                            <input type="file" name="foto_profil" class="form-control @error('foto_profil') is-invalid @enderror" accept="image/*">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto.</small>
                        </div>
                    </div>
                    @error('foto_profil') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12"><hr><h6 class="fw-bold text-primary"><i class="bi bi-mortarboard me-2"></i>Penugasan Pembimbing</h6></div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Dosen Pembimbing I</label>
                    <select name="pembimbing1_id" class="form-select @error('pembimbing1_id') is-invalid @enderror">
                        <option value="">-- Belum Ditentukan --</option>
                        @foreach($dosens as $d)
                            <option value="{{ $d->id }}" {{ old('pembimbing1_id', $mahasiswa->pembimbing1_id) == $d->id ? 'selected' : '' }}>{{ $d->nama_dosen }}</option>
                        @endforeach
                    </select>
                    @error('pembimbing1_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Dosen Pembimbing II</label>
                    <select name="pembimbing2_id" class="form-select @error('pembimbing2_id') is-invalid @enderror">
                        <option value="">-- Belum Ditentukan --</option>
                        @foreach($dosens as $d)
                            <option value="{{ $d->id }}" {{ old('pembimbing2_id', $mahasiswa->pembimbing2_id) == $d->id ? 'selected' : '' }}>{{ $d->nama_dosen }}</option>
                        @endforeach
                    </select>
                    @error('pembimbing2_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
