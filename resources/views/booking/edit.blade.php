@extends('layouts.app')

@section('title', 'Edit Booking')
@section('page-title', 'Edit Booking')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="form-card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Booking Konsultasi</h5>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger" style="border-radius:10px; border:none; background:rgba(239,68,68,0.1); color:#b91c1c;">
                        <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                <form action="{{ route('booking.update', $booking) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Mahasiswa <span class="text-danger">*</span></label>
                            <input type="text" name="nama_mahasiswa" class="form-control" value="{{ old('nama_mahasiswa', $booking->nama_mahasiswa) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">NIM <span class="text-danger">*</span></label>
                            <input type="text" name="nim" class="form-control" value="{{ old('nim', $booking->nim) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Program Studi <span class="text-danger">*</span></label>
                            <input type="text" name="prodi" class="form-control" value="{{ old('prodi', $booking->prodi) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Dosen <span class="text-danger">*</span></label>
                            <select name="dosen_id" class="form-select" required>
                                <option value="">-- Pilih Dosen --</option>
                                @foreach($dosens as $dosen)
                                    <option value="{{ $dosen->id }}" {{ old('dosen_id', $booking->dosen_id) == $dosen->id ? 'selected' : '' }}>{{ $dosen->nama_dosen }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $booking->tanggal) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Jam <span class="text-danger">*</span></label>
                            <input type="time" name="jam" class="form-control" value="{{ old('jam', \Carbon\Carbon::parse($booking->jam)->format('H:i')) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select" required>
                                @foreach(['Menunggu','Disetujui','Ditolak','Selesai'] as $s)
                                    <option value="{{ $s }}" {{ old('status', $booking->status) == $s ? 'selected' : '' }}>{{ $s }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Topik <span class="text-danger">*</span></label>
                            <textarea name="topik" class="form-control" rows="3" required>{{ old('topik', $booking->topik) }}</textarea>
                        </div>
                        <div class="col-12 d-flex gap-2">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i> Update</button>
                            <a href="{{ route('booking.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
