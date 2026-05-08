@extends('layouts.dosen')

@section('title', 'Edit Jadwal Bimbingan')
@section('page-title', 'Edit Jadwal Bimbingan')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="form-card">
            <div class="card-header bg-white border-bottom-0 pb-0">
                <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2 text-warning"></i>Edit Jadwal Bimbingan</h5>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger" style="border-radius:10px; border:none; background:rgba(239,68,68,0.1); color:#b91c1c;">
                        <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                <form action="{{ route('dosen-panel.jadwal.update', $jadwal) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Hari <span class="text-danger">*</span></label>
                            <select name="hari" class="form-select" required>
                                @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $hari)
                                    <option value="{{ $hari }}" {{ old('hari', $jadwal->hari) == $hari ? 'selected' : '' }}>{{ $hari }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Kuota Mahasiswa <span class="text-danger">*</span></label>
                            <input type="number" name="kuota" class="form-control" value="{{ old('kuota', $jadwal->kuota) }}" min="1" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Jam Mulai <span class="text-danger">*</span></label>
                            <input type="time" name="jam_mulai" class="form-control" value="{{ old('jam_mulai', \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i')) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Jam Selesai <span class="text-danger">*</span></label>
                            <input type="time" name="jam_selesai" class="form-control" value="{{ old('jam_selesai', \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i')) }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Keterangan Topik (Opsional)</label>
                            <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan', $jadwal->keterangan) }}</textarea>
                        </div>
                        <div class="col-12 d-flex gap-2 mt-4">
                            <button type="submit" class="btn text-white px-4" style="background-color: #0f766e;"><i class="bi bi-check-lg me-1"></i> Simpan Perubahan</button>
                            <a href="{{ route('dosen-panel.jadwal.index') }}" class="btn btn-light"><i class="bi bi-arrow-left me-1"></i> Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
