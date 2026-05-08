<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenPanelController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ===== AUTHENTICATION =====
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===== HALAMAN PUBLIK =====
Route::get('/', [MahasiswaController::class, 'beranda'])->name('beranda');
Route::get('/jadwal-konsultasi', [MahasiswaController::class, 'jadwal'])->name('mahasiswa.jadwal');

// ===== PANEL MAHASISWA =====
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::post('/booking-konsultasi', [MahasiswaController::class, 'bookingStore'])->name('mahasiswa.booking.store');
    Route::get('/profil', [MahasiswaController::class, 'profil'])->name('mahasiswa.profil');
    Route::post('/profil', [MahasiswaController::class, 'updateProfil'])->name('mahasiswa.profil.update');
    Route::get('/riwayat', [MahasiswaController::class, 'riwayat'])->name('mahasiswa.riwayat');
    Route::get('/riwayat/unduh', [MahasiswaController::class, 'unduhRiwayat'])->name('mahasiswa.riwayat.unduh');
});

// ===== HALAMAN ADMIN =====
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('dosen', DosenController::class);
    Route::get('/mahasiswa', [App\Http\Controllers\MahasiswaAdminController::class, 'index'])->name('admin.mahasiswa.index');
    Route::get('/mahasiswa/create', [App\Http\Controllers\MahasiswaAdminController::class, 'create'])->name('admin.mahasiswa.create');
    Route::post('/mahasiswa', [App\Http\Controllers\MahasiswaAdminController::class, 'store'])->name('admin.mahasiswa.store');
    Route::get('/mahasiswa/{mahasiswa}/edit', [App\Http\Controllers\MahasiswaAdminController::class, 'edit'])->name('admin.mahasiswa.edit');
    Route::put('/mahasiswa/{mahasiswa}', [App\Http\Controllers\MahasiswaAdminController::class, 'update'])->name('admin.mahasiswa.update');
    Route::delete('/mahasiswa/{mahasiswa}', [App\Http\Controllers\MahasiswaAdminController::class, 'destroy'])->name('admin.mahasiswa.destroy');
    Route::get('/laporan-booking', [BookingController::class, 'laporan'])->name('booking.laporan');
    Route::get('/laporan-booking/unduh', [BookingController::class, 'unduhLaporan'])->name('booking.laporan.unduh');
    Route::get('/settings', [App\Http\Controllers\SettingController::class, 'index'])->name('admin.settings');
    Route::put('/settings', [App\Http\Controllers\SettingController::class, 'update'])->name('admin.settings.update');
});

// ===== PANEL DOSEN =====
Route::prefix('dosen-panel')->name('dosen-panel.')->middleware(['auth', 'role:dosen'])->group(function () {
    Route::get('/', [DosenPanelController::class, 'dashboard'])->name('dashboard');
    
    // Jadwal (Buka Bimbingan)
    Route::get('/jadwal', [DosenPanelController::class, 'jadwalIndex'])->name('jadwal.index');
    Route::get('/jadwal/create', [DosenPanelController::class, 'jadwalCreate'])->name('jadwal.create');
    Route::post('/jadwal', [DosenPanelController::class, 'jadwalStore'])->name('jadwal.store');
    Route::get('/jadwal/{jadwal}/edit', [DosenPanelController::class, 'jadwalEdit'])->name('jadwal.edit');
    Route::put('/jadwal/{jadwal}', [DosenPanelController::class, 'jadwalUpdate'])->name('jadwal.update');
    Route::delete('/jadwal/{jadwal}', [DosenPanelController::class, 'jadwalDestroy'])->name('jadwal.destroy');
    
    // Booking Masuk
    Route::get('/booking', [DosenPanelController::class, 'bookingIndex'])->name('booking.index');
    Route::patch('/booking/{booking}/status', [DosenPanelController::class, 'bookingUpdateStatus'])->name('booking.updateStatus');
});
