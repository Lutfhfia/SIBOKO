Struktur Project Laravel
sibokon/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── DashboardController.php
│   │   │   ├── DosenController.php
│   │   │   ├── JadwalController.php
│   │   │   └── BookingController.php
│   │   │
│   │   └── Requests/
│   │       ├── DosenRequest.php
│   │       ├── JadwalRequest.php
│   │       └── BookingRequest.php
│   │
│   └── Models/
│       ├── Dosen.php
│       ├── Jadwal.php
│       └── Booking.php
│
├── database/
│   ├── migrations/
│   │   ├── create_dosens_table.php
│   │   ├── create_jadwals_table.php
│   │   └── create_bookings_table.php
│   │
│   └── seeders/
│       ├── DosenSeeder.php
│       ├── JadwalSeeder.php
│       └── DatabaseSeeder.php
│
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       │
│       ├── dashboard/
│       │   └── index.blade.php
│       │
│       ├── dosen/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   └── show.blade.php
│       │
│       ├── jadwal/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   └── show.blade.php
│       │
│       ├── booking/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   └── show.blade.php
│       │
│       └── laporan/
│           └── booking.blade.php
│
├── routes/
│   └── web.php
│
├── public/
│   ├── css/
│   │   └── style.css
│   │
│   └── js/
│       └── script.js
│
├── .env
└── composer.json
1. Struktur Frontend

Frontend adalah bagian tampilan aplikasi yang dilihat dan digunakan oleh user.

Di Laravel, frontend utama berada di folder:

resources/views/
Struktur Folder Frontend
resources/views/
│
├── layouts/
│   └── app.blade.php
│
├── dashboard/
│   └── index.blade.php
│
├── dosen/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
│
├── jadwal/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
│
├── booking/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
│
└── laporan/
    └── booking.blade.php
Fungsi Setiap File Frontend
layouts/app.blade.php

File utama untuk template aplikasi.

Isi biasanya:

Navbar
Sidebar
Link Bootstrap
Tempat konten halaman
Footer

Contoh fungsi:

Sebagai layout utama agar semua halaman memiliki tampilan yang sama.
dashboard/index.blade.php

Halaman utama aplikasi.

Isi:

Total dosen
Total jadwal
Total booking
Total booking menunggu
Total booking disetujui
Total booking ditolak
dosen/index.blade.php

Halaman daftar data dosen.

Isi:

Tabel data dosen
Tombol tambah
Tombol edit
Tombol hapus
Tombol detail
dosen/create.blade.php

Halaman form tambah dosen.

Input:

Nama dosen
NIDN/NIP
Bidang keahlian
Email
Nomor HP
dosen/edit.blade.php

Halaman form edit data dosen.

dosen/show.blade.php

Halaman detail dosen.

jadwal/index.blade.php

Halaman daftar jadwal konsultasi.

Isi:

Nama dosen
Hari
Jam mulai
Jam selesai
Kuota
Keterangan
jadwal/create.blade.php

Halaman form tambah jadwal konsultasi.

Input:

Pilih dosen
Hari
Jam mulai
Jam selesai
Kuota
Keterangan
jadwal/edit.blade.php

Halaman edit jadwal konsultasi.

booking/index.blade.php

Halaman daftar booking konsultasi.

Isi:

Nama mahasiswa
NIM
Prodi
Dosen
Tanggal
Jam
Topik
Status
Aksi
booking/create.blade.php

Halaman form tambah booking.

Input:

Nama mahasiswa
NIM
Prodi
Pilih dosen
Tanggal konsultasi
Jam konsultasi
Topik konsultasi

Status awal otomatis:

Menunggu
booking/edit.blade.php

Halaman edit booking dan ubah status.

Status yang bisa dipilih:

Menunggu
Disetujui
Ditolak
Selesai
laporan/booking.blade.php

Halaman laporan data booking.

Isi:

Rekap seluruh booking
Filter status
Filter dosen
Filter tanggal
2. Struktur Backend

Backend adalah bagian sistem yang mengatur logika aplikasi, database, controller, model, dan route.

Struktur Folder Backend
app/
│
├── Http/
│   └── Controllers/
│       ├── DashboardController.php
│       ├── DosenController.php
│       ├── JadwalController.php
│       └── BookingController.php
│
└── Models/
    ├── Dosen.php
    ├── Jadwal.php
    └── Booking.php
Fungsi Setiap Controller
DashboardController.php

Mengatur data yang tampil di dashboard.

Fungsi utama:

index()

Isi data:

Hitung total dosen
Hitung total jadwal
Hitung total booking
Hitung booking berdasarkan status
DosenController.php

Mengatur semua proses CRUD data dosen.

Fungsi:

index()
create()
store()
show()
edit()
update()
destroy()

Keterangan:

Fungsi	Kegunaan
index	Menampilkan daftar dosen
create	Menampilkan form tambah dosen
store	Menyimpan data dosen baru
show	Menampilkan detail dosen
edit	Menampilkan form edit dosen
update	Menyimpan perubahan data dosen
destroy	Menghapus data dosen
JadwalController.php

Mengatur CRUD jadwal konsultasi.

Fungsi:

index()
create()
store()
show()
edit()
update()
destroy()

Fitur tambahan:

Menampilkan relasi dosen
Validasi jam mulai dan jam selesai
BookingController.php

Mengatur CRUD booking konsultasi.

Fungsi:

index()
create()
store()
show()
edit()
update()
destroy()

Fitur tambahan:

Validasi bentrok jadwal
Status otomatis “Menunggu”
Ubah status booking
3. Struktur Model

Model digunakan untuk menghubungkan Laravel dengan tabel database.

app/Models/
│
├── Dosen.php
├── Jadwal.php
└── Booking.php
Model Dosen.php

Relasi:

Satu dosen memiliki banyak jadwal
Satu dosen memiliki banyak booking

Relasi Laravel:

public function jadwals()
{
    return $this->hasMany(Jadwal::class);
}

public function bookings()
{
    return $this->hasMany(Booking::class);
}
Model Jadwal.php

Relasi:

Satu jadwal dimiliki oleh satu dosen

Relasi Laravel:

public function dosen()
{
    return $this->belongsTo(Dosen::class);
}
Model Booking.php

Relasi:

Satu booking dimiliki oleh satu dosen

Relasi Laravel:

public function dosen()
{
    return $this->belongsTo(Dosen::class);
}
4. Struktur Database
Tabel dosens
id
nama_dosen
nidn
bidang_keahlian
email
no_hp
created_at
updated_at
Tabel jadwals
id
dosen_id
hari
jam_mulai
jam_selesai
kuota
keterangan
created_at
updated_at
Tabel bookings
id
nama_mahasiswa
nim
prodi
dosen_id
tanggal
jam
topik
status
created_at
updated_at
5. Struktur Route

File route ada di:

routes/web.php

Contoh struktur route:

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\BookingController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('dosen', DosenController::class);
Route::resource('jadwal', JadwalController::class);
Route::resource('booking', BookingController::class);

Route::get('/laporan-booking', [BookingController::class, 'laporan'])->name('booking.laporan');
6. Alur Frontend dan Backend
User membuka halaman booking
↓
Frontend menampilkan form booking
↓
User mengisi form
↓
Data dikirim ke BookingController
↓
Controller melakukan validasi
↓
Controller mengecek bentrok jadwal
↓
Jika aman, data disimpan ke tabel bookings
↓
User diarahkan ke halaman daftar booking
7. Pembagian Frontend dan Backend
Bagian	File/Folder	Fungsi
Frontend	resources/views	Tampilan halaman
Frontend	public/css	Styling tambahan
Frontend	public/js	Script tambahan
Backend	app/Http/Controllers	Logika CRUD
Backend	app/Models	Relasi database
Backend	database/migrations	Struktur tabel
Backend	routes/web.php	Penghubung URL ke controller
Database	MySQL via Laragon	Penyimpanan data
8. Struktur Final yang Paling Aman untuk Ujikom

Kalau mau dibuat sederhana, pakai struktur ini saja:

sibokon/
│
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── DashboardController.php
│   │       ├── DosenController.php
│   │       ├── JadwalController.php
│   │       └── BookingController.php
│   │
│   └── Models/
│       ├── Dosen.php
│       ├── Jadwal.php
│       └── Booking.php
│
├── database/
│   └── migrations/
│       ├── create_dosens_table.php
│       ├── create_jadwals_table.php
│       └── create_bookings_table.php
│
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── dashboard/
│       │   └── index.blade.php
│       ├── dosen/
│       ├── jadwal/
│       └── booking/
│
└── routes/
    └── web.php
Kesimpulan

Untuk ujikom, kamu bisa menjelaskan seperti ini:

Frontend aplikasi dibuat menggunakan Blade Template dan Bootstrap untuk menampilkan halaman dashboard, data dosen, jadwal konsultasi, booking konsultasi, dan laporan. Backend aplikasi dibuat menggunakan Laravel Controller, Model, Migration, dan Route untuk mengelola proses CRUD, validasi data, relasi antar tabel, serta penyimpanan data ke database MySQL melalui Laragon.