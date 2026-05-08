@extends('layouts.app')

@section('title', 'Detail Booking')
@section('page-title', 'Detail Booking')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="form-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-journal-bookmark me-2"></i>Detail Booking</h5>
                <a href="{{ route('booking.index') }}" class="btn btn-sm btn-light"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr><th style="width:180px;">Nama Mahasiswa</th><td>{{ $booking->nama_mahasiswa }}</td></tr>
                    <tr><th>NIM</th><td>{{ $booking->nim }}</td></tr>
                    <tr><th>Program Studi</th><td>{{ $booking->prodi }}</td></tr>
                    <tr><th>Dosen</th><td>{{ $booking->dosen->nama_dosen ?? '-' }}</td></tr>
                    <tr><th>Tanggal</th><td>{{ \Carbon\Carbon::parse($booking->tanggal)->format('d M Y') }}</td></tr>
                    <tr><th>Jam</th><td>{{ \Carbon\Carbon::parse($booking->jam)->format('H:i') }}</td></tr>
                    <tr><th>Topik</th><td>{{ $booking->topik }}</td></tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($booking->status == 'Menunggu')
                                <span class="badge-menunggu">{{ $booking->status }}</span>
                            @elseif($booking->status == 'Disetujui')
                                <span class="badge-disetujui">{{ $booking->status }}</span>
                            @elseif($booking->status == 'Ditolak')
                                <span class="badge-ditolak">{{ $booking->status }}</span>
                            @else
                                <span class="badge-selesai">{{ $booking->status }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr><th>Dibuat</th><td>{{ $booking->created_at->format('d M Y H:i') }}</td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
