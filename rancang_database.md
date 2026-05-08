Rancangan Database

Nama database:

db_sibokon

Database terdiri dari 3 tabel utama:

dosens
jadwals
bookings
1. Tabel dosens

Tabel ini digunakan untuk menyimpan data dosen yang dapat menerima konsultasi mahasiswa.

Struktur Tabel dosens
No	Field	Tipe Data	Keterangan
1	id	bigint unsigned	Primary key
2	nama_dosen	varchar(100)	Nama dosen
3	nidn	varchar(30)	Nomor induk dosen
4	bidang_keahlian	varchar(100)	Bidang keahlian dosen
5	email	varchar(100)	Email dosen
6	no_hp	varchar(20)	Nomor HP dosen
7	created_at	timestamp	Waktu data dibuat
8	updated_at	timestamp	Waktu data diperbarui
Contoh Data
id	nama_dosen	nidn	bidang_keahlian	email	no_hp
1	Dr. Andi Saputra	00112233	Akademik	andi@email.com
	08123456789
2	Bu Rina Lestari	00445566	Bimbingan Skripsi	rina@email.com
	08234567890
2. Tabel jadwals

Tabel ini digunakan untuk menyimpan jadwal konsultasi yang disediakan oleh dosen.

Struktur Tabel jadwals
No	Field	Tipe Data	Keterangan
1	id	bigint unsigned	Primary key
2	dosen_id	bigint unsigned	Foreign key ke tabel dosens
3	hari	varchar(20)	Hari konsultasi
4	jam_mulai	time	Jam mulai konsultasi
5	jam_selesai	time	Jam selesai konsultasi
6	kuota	integer	Jumlah kuota konsultasi
7	keterangan	text	Keterangan tambahan
8	created_at	timestamp	Waktu data dibuat
9	updated_at	timestamp	Waktu data diperbarui
Contoh Data
id	dosen_id	hari	jam_mulai	jam_selesai	kuota	keterangan
1	1	Senin	09:00	11:00	5	Konsultasi akademik
2	2	Rabu	13:00	15:00	4	Konsultasi skripsi
3. Tabel bookings

Tabel ini digunakan untuk menyimpan data booking konsultasi mahasiswa dengan dosen.

Struktur Tabel bookings
No	Field	Tipe Data	Keterangan
1	id	bigint unsigned	Primary key
2	dosen_id	bigint unsigned	Foreign key ke tabel dosens
3	nama_mahasiswa	varchar(100)	Nama mahasiswa
4	nim	varchar(30)	Nomor induk mahasiswa
5	prodi	varchar(100)	Program studi mahasiswa
6	tanggal	date	Tanggal konsultasi
7	jam	time	Jam konsultasi
8	topik	text	Topik konsultasi
9	status	enum/string	Status booking
10	created_at	timestamp	Waktu data dibuat
11	updated_at	timestamp	Waktu data diperbarui
Status Booking
Menunggu
Disetujui
Ditolak
Selesai
Contoh Data
id	dosen_id	nama_mahasiswa	nim	prodi	tanggal	jam	topik	status
1	1	Raisya Fanisha	20230101	Ilmu Komunikasi	2026-05-10	09:00	Konsultasi KRS	Menunggu
2	2	Ahmad Rizki	20230102	Sistem Informasi	2026-05-11	13:00	Konsultasi Skripsi	Disetujui
Relasi Antar Tabel

Relasi yang digunakan adalah:

1. Relasi dosens ke jadwals

Satu dosen dapat memiliki banyak jadwal konsultasi.

dosens 1 ---- * jadwals

Artinya:

1 dosen bisa punya banyak jadwal.
1 jadwal hanya dimiliki oleh 1 dosen.

Contoh:

Dr. Andi memiliki jadwal:
- Senin 09.00–11.00
- Rabu 13.00–15.00
2. Relasi dosens ke bookings

Satu dosen dapat memiliki banyak booking konsultasi.

dosens 1 ---- * bookings

Artinya:

1 dosen bisa menerima banyak booking.
1 booking hanya memilih 1 dosen.

Contoh:

Dr. Andi menerima booking dari:
- Raisya
- Ahmad
- Siti
Diagram Relasi Database
+------------------+
|     dosens       |
+------------------+
| id               | PK
| nama_dosen       |
| nidn             |
| bidang_keahlian  |
| email            |
| no_hp            |
| created_at       |
| updated_at       |
+------------------+
        |
        | 1
        |
        | *
+------------------+
|     jadwals      |
+------------------+
| id               | PK
| dosen_id         | FK
| hari             |
| jam_mulai        |
| jam_selesai      |
| kuota            |
| keterangan       |
| created_at       |
| updated_at       |
+------------------+


+------------------+
|     dosens       |
+------------------+
| id               | PK
| nama_dosen       |
| nidn             |
| bidang_keahlian  |
| email            |
| no_hp            |
| created_at       |
| updated_at       |
+------------------+
        |
        | 1
        |
        | *
+------------------+
|    bookings      |
+------------------+
| id               | PK
| dosen_id         | FK
| nama_mahasiswa   |
| nim              |
| prodi            |
| tanggal          |
| jam              |
| topik            |
| status           |
| created_at       |
| updated_at       |
+------------------+
ERD Sederhana
DOSENS
id PK
nama_dosen
nidn
bidang_keahlian
email
no_hp
created_at
updated_at

        1
        |
        |
        *
JADWALS
id PK
dosen_id FK
hari
jam_mulai
jam_selesai
kuota
keterangan
created_at
updated_at


DOSENS
id PK
nama_dosen
nidn
bidang_keahlian
email
no_hp
created_at
updated_at

        1
        |
        |
        *
BOOKINGS
id PK
dosen_id FK
nama_mahasiswa
nim
prodi
tanggal
jam
topik
status
created_at
updated_at
Versi Relasi dalam Laravel Model
Model Dosen.php
public function jadwals()
{
    return $this->hasMany(Jadwal::class);
}

public function bookings()
{
    return $this->hasMany(Booking::class);
}
Model Jadwal.php
public function dosen()
{
    return $this->belongsTo(Dosen::class);
}
Model Booking.php
public function dosen()
{
    return $this->belongsTo(Dosen::class);
}
Migration Laravel
Migration Tabel dosens
Schema::create('dosens', function (Blueprint $table) {
    $table->id();
    $table->string('nama_dosen', 100);
    $table->string('nidn', 30)->unique();
    $table->string('bidang_keahlian', 100);
    $table->string('email', 100)->nullable();
    $table->string('no_hp', 20)->nullable();
    $table->timestamps();
});
Migration Tabel jadwals
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
Migration Tabel bookings
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
Catatan Penting untuk Ujikom

Untuk aplikasi sederhana, struktur di atas sudah cukup. Namun, kalau ingin lebih rapi, tabel bookings bisa juga dibuat berelasi langsung dengan jadwals, bukan hanya dosens.

Versi yang lebih rapi

Tambahkan jadwal_id di tabel bookings.

bookings
- id
- jadwal_id
- nama_mahasiswa
- nim
- prodi
- tanggal
- jam
- topik
- status

Relasinya menjadi:

dosens 1 ---- * jadwals
jadwals 1 ---- * bookings

Artinya:

Dosen punya banyak jadwal.
Jadwal bisa memiliki banyak booking.
Booking dilakukan berdasarkan jadwal tertentu.

Tapi untuk ujikom yang simple, versi awal dengan dosen_id di tabel bookings sudah lebih mudah dibuat dan dijelaskan.