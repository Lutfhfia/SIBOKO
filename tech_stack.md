Siap, kita mulai buat aplikasi SIBOKON: Sistem Booking Konsultasi Mahasiswa pakai Laravel + Laragon.

Kita buat versi simple dulu: CRUD Dosen, CRUD Jadwal, CRUD Booking.

1. Nyalakan Laragon

Buka Laragon, lalu klik:

Start All

Pastikan Apache/Nginx dan MySQL sudah jalan.

2. Buat Project Laravel

Buka terminal Laragon:

Menu → Terminal

Lalu masuk ke folder www:

cd C:\laragon\www

Buat project Laravel:

composer create-project laravel/laravel sibokon

Masuk ke folder project:

cd sibokon

Jalankan Laravel:

php artisan serve

Buka browser:

http://127.0.0.1:8000

Kalau halaman Laravel muncul, berarti project berhasil dibuat.

3. Buat Database di Laragon

Buka:

Laragon → Database → HeidiSQL / phpMyAdmin

Buat database baru:

CREATE DATABASE db_sibokon;

Atau manual buat database dengan nama:

db_sibokon
4. Atur File .env

Buka project sibokon di VS Code, lalu buka file:

.env

Cari bagian database, ubah jadi seperti ini:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_sibokon
DB_USERNAME=root
DB_PASSWORD=

Biasanya Laragon pakai:

username: root
password: kosong

Setelah itu jalankan:

php artisan config:clear
5. Buat Model, Migration, dan Controller

Jalankan perintah ini satu per satu:

php artisan make:model Dosen -mcr
php artisan make:model Jadwal -mcr
php artisan make:model Booking -mcr

Keterangan:

-m = migration
-c = controller
-r = resource controller

Nanti otomatis dibuat:

app/Models/Dosen.php
app/Models/Jadwal.php
app/Models/Booking.php

app/Http/Controllers/DosenController.php
app/Http/Controllers/JadwalController.php
app/Http/Controllers/BookingController.php

database/migrations/...
6. Buat Dashboard Controller

Jalankan:

php artisan make:controller DashboardController
7. Edit Migration Tabel dosens

Buka file migration yang namanya mirip:

database/migrations/xxxx_xx_xx_xxxxxx_create_dosens_table.php

Isi bagian up() menjadi:

public function up(): void
{
    Schema::create('dosens', function (Blueprint $table) {
        $table->id();
        $table->string('nama_dosen', 100);
        $table->string('nidn', 30)->unique();
        $table->string('bidang_keahlian', 100);
        $table->string('email', 100)->nullable();
        $table->string('no_hp', 20)->nullable();
        $table->timestamps();
    });
}
8. Edit Migration Tabel jadwals

Buka file:

database/migrations/xxxx_xx_xx_xxxxxx_create_jadwals_table.php

Isi bagian up() menjadi:

public function up(): void
{
    Schema::create('jadwals', function (Blueprint $table) {
        $table->id();
        $table->foreignId('dosen_id')->constrained('dosens')->onDelete('cascade');
        $table->string('hari', 20);
        $table->time('jam_mulai');
        $table->time('jam_selesai');
        $table->integer('kuota')->default(1);
        $table->text('keterangan')->nullable();
        $table->timestamps();
    });
}
9. Edit Migration Tabel bookings

Buka file:

database/migrations/xxxx_xx_xx_xxxxxx_create_bookings_table.php

Isi bagian up() menjadi:

public function up(): void
{
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('dosen_id')->constrained('dosens')->onDelete('cascade');
        $table->string('nama_mahasiswa', 100);
        $table->string('nim', 30);
        $table->string('prodi', 100);
        $table->date('tanggal');
        $table->time('jam');
        $table->text('topik');
        $table->enum('status', ['Menunggu', 'Disetujui', 'Ditolak', 'Selesai'])->default('Menunggu');
        $table->timestamps();
    });
}
10. Jalankan Migration

Di terminal, jalankan:

php artisan migrate

Kalau berhasil, nanti muncul tabel:

dosens
jadwals
bookings
11. Edit Model Dosen.php

Buka:

app/Models/Dosen.php

Isi menjadi:

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $fillable = [
        'nama_dosen',
        'nidn',
        'bidang_keahlian',
        'email',
        'no_hp',
    ];

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
12. Edit Model Jadwal.php

Buka:

app/Models/Jadwal.php

Isi menjadi:

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $fillable = [
        'dosen_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'kuota',
        'keterangan',
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }
}
13. Edit Model Booking.php

Buka:

app/Models/Booking.php

Isi menjadi:

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'dosen_id',
        'nama_mahasiswa',
        'nim',
        'prodi',
        'tanggal',
        'jam',
        'topik',
        'status',
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }
}
14. Buat Route

Buka file:

routes/web.php

Ganti isinya menjadi:

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\BookingController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('dosen', DosenController::class);
Route::resource('jadwal', JadwalController::class);
Route::resource('booking', BookingController::class);

Route::get('/laporan-booking', [BookingController::class, 'laporan'])->name('booking.laporan');
15. Buat Folder View

Di dalam folder:

resources/views

Buat folder berikut:

layouts
dashboard
dosen
jadwal
booking
laporan

Strukturnya jadi seperti ini:

resources/views/
├── layouts/
├── dashboard/
├── dosen/
├── jadwal/
├── booking/
└── laporan/
Checklist Tahap Pertama

Pastikan kamu sudah punya:

✅ Project Laravel sibokon
✅ Database db_sibokon
✅ Tabel dosens
✅ Tabel jadwals
✅ Tabel bookings
✅ Model Dosen, Jadwal, Booking
✅ Controller Dosen, Jadwal, Booking, Dashboard
✅ Route resource
✅ Folder view