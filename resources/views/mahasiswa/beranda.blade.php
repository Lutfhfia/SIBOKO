@extends('layouts.mahasiswa')

@section('title', 'Beranda')

@section('content')
{{-- Hero Section --}}
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1>Booking Konsultasi<br>Dosen Jadi Mudah!</h1>
                <p class="lead mb-4">
                    SIBOKO membantu kamu mengatur jadwal konsultasi dengan dosen secara online.
                    Pilih dosen, tentukan waktu, dan tunggu konfirmasi. Tidak perlu antri lagi!
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    @auth
                        <a href="javascript:void(0)" onclick="openBookingModal()" class="btn-hero">
                            <i class="bi bi-journal-plus me-2"></i>Booking Sekarang
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-hero">
                            <i class="bi bi-journal-plus me-2"></i>Booking Sekarang
                        </a>
                    @endauth
                    <a href="{{ route('mahasiswa.jadwal') }}" class="btn-hero-outline">
                        <i class="bi bi-clock me-2"></i>Lihat Jadwal
                    </a>
                </div>
            </div>
            <div class="col-lg-5 text-center mt-5 mt-lg-0">
                <div style="font-size: 8rem; opacity: 0.15;">
                    <i class="bi bi-calendar2-check"></i>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Cara Menggunakan --}}
<section class="py-5" style="background: white;">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h2 class="section-title">Cara Menggunakan SIBOKO</h2>
            <p class="section-subtitle">Tiga langkah mudah untuk booking konsultasi</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <h5>Pilih Dosen</h5>
                    <p>Lihat daftar dosen dan jadwal konsultasi yang tersedia sesuai kebutuhanmu.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-card">
                    <div class="step-number">2</div>
                    <h5>Isi Form Booking</h5>
                    <p>Lengkapi data diri dan pilih waktu konsultasi yang diinginkan.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-card">
                    <div class="step-number">3</div>
                    <h5>Tunggu Konfirmasi</h5>
                    <p>Cek status booking secara berkala. Admin/dosen akan mengonfirmasi jadwalmu.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Info Singkat --}}
<section class="py-5">
    <div class="container py-4">
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="stat-card stat-primary text-center">
                    <div class="stat-icon mx-auto"><i class="bi bi-person-badge-fill"></i></div>
                    <div class="stat-value">{{ $totalDosen }}</div>
                    <div class="stat-label">Dosen Tersedia</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card stat-info text-center">
                    <div class="stat-icon mx-auto"><i class="bi bi-clock-fill"></i></div>
                    <div class="stat-value">{{ $totalJadwal }}</div>
                    <div class="stat-label">Jadwal Konsultasi</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card stat-success text-center">
                    <div class="stat-icon mx-auto"><i class="bi bi-check-circle-fill"></i></div>
                    <div class="stat-value"><i class="bi bi-lightning-charge-fill" style="font-size:1.5rem;"></i></div>
                    <div class="stat-label">Booking Cepat & Mudah</div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
