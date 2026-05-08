@extends('layouts.app')

@section('title', 'Detail Jadwal')
@section('page-title', 'Detail Jadwal')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="form-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-clock me-2"></i>Detail Jadwal Konsultasi</h5>
                <a href="{{ route('jadwal.index') }}" class="btn btn-sm btn-light"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr><th style="width:180px;">Dosen</th><td>{{ $jadwal->dosen->nama_dosen ?? '-' }}</td></tr>
                    <tr><th>Hari</th><td>{{ $jadwal->hari }}</td></tr>
                    <tr><th>Jam Mulai</th><td>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}</td></tr>
                    <tr><th>Jam Selesai</th><td>{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td></tr>
                    <tr><th>Kuota</th><td>{{ $jadwal->kuota }}</td></tr>
                    <tr><th>Keterangan</th><td>{{ $jadwal->keterangan ?? '-' }}</td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
