Siap. Ini modul sistem aplikasi SIBOKON: Sistem Booking Konsultasi Mahasiswa yang cocok untuk ujikom Laravel + Laragon, sederhana tapi tetap terlihat lengkap.

Modul Sistem Aplikasi
1. Modul Dashboard

Modul ini digunakan sebagai halaman utama aplikasi untuk menampilkan ringkasan data konsultasi.

Isi Dashboard
Total data dosen
Total jadwal konsultasi
Total booking konsultasi
Total booking menunggu
Total booking disetujui
Total booking ditolak
Total booking selesai
Tujuan Modul

Memudahkan admin melihat kondisi data konsultasi secara cepat.

2. Modul Data Dosen

Modul ini digunakan untuk mengelola data dosen yang tersedia untuk konsultasi mahasiswa.

Fitur
Menambahkan data dosen
Menampilkan daftar dosen
Mengubah data dosen
Menghapus data dosen
Melihat detail dosen
Data yang Diinput
Nama dosen
NIDN/NIP
Bidang keahlian
Email
Nomor HP
Contoh Tabel
No	Nama Dosen	NIDN	Bidang Keahlian	Email	Aksi
1	Dr. Andi	12345	Akademik	andi@email.com
	Edit / Hapus
3. Modul Jadwal Konsultasi

Modul ini digunakan untuk mengatur jadwal konsultasi dosen agar mahasiswa dapat memilih waktu yang tersedia.

Fitur
Menambahkan jadwal konsultasi
Menampilkan daftar jadwal
Mengubah jadwal
Menghapus jadwal
Melihat jadwal berdasarkan dosen
Data yang Diinput
Nama dosen
Hari
Jam mulai
Jam selesai
Kuota konsultasi
Keterangan
Contoh Tabel
No	Dosen	Hari	Jam Mulai	Jam Selesai	Kuota	Aksi
1	Dr. Andi	Senin	09.00	11.00	5	Edit / Hapus
4. Modul Booking Konsultasi

Modul ini merupakan modul utama aplikasi. Mahasiswa dapat melakukan booking konsultasi dengan dosen sesuai jadwal yang tersedia.

Fitur
Menambahkan data booking
Menampilkan daftar booking
Mengubah data booking
Menghapus data booking
Mengubah status booking
Validasi bentrok jadwal
Data yang Diinput
Nama mahasiswa
NIM
Program studi
Dosen yang dipilih
Tanggal konsultasi
Jam konsultasi
Topik konsultasi
Status booking
Status Booking
Menunggu
Disetujui
Ditolak
Selesai
Contoh Tabel
No	Mahasiswa	NIM	Dosen	Tanggal	Jam	Topik	Status	Aksi
1	Raisya	20230101	Dr. Andi	10-05-2026	09.00	Bimbingan KRS	Menunggu	Edit / Hapus / Ubah Status
5. Modul Validasi Bentrok Jadwal

Modul ini digunakan untuk mencegah terjadinya booking pada waktu yang sama dengan dosen yang sama.

Aturan Sistem

Mahasiswa tidak dapat melakukan booking jika:

Dosen sama
Tanggal sama
Jam konsultasi sama
Status booking masih menunggu atau disetujui
Contoh Pesan Validasi

Jadwal konsultasi sudah dibooking oleh mahasiswa lain. Silakan pilih waktu yang berbeda.

Tujuan Modul

Menghindari bentrok waktu antara mahasiswa dan dosen.

6. Modul Status Booking

Modul ini digunakan oleh admin atau dosen untuk mengatur status konsultasi mahasiswa.

Fitur
Mengubah status dari Menunggu menjadi Disetujui
Mengubah status dari Menunggu menjadi Ditolak
Mengubah status dari Disetujui menjadi Selesai
Alur Status
Menunggu → Disetujui → Selesai
Menunggu → Ditolak
Contoh Penggunaan

Mahasiswa membuat booking. Status awal otomatis menjadi Menunggu. Setelah admin/dosen memeriksa, status dapat diubah menjadi Disetujui atau Ditolak.

7. Modul Laporan Booking

Modul ini digunakan untuk menampilkan rekap data booking konsultasi.

Fitur
Menampilkan semua data booking
Filter berdasarkan status
Filter berdasarkan dosen
Filter berdasarkan tanggal
Cetak laporan sederhana atau export PDF/Excel jika sempat
Data Laporan
Nama mahasiswa
NIM
Nama dosen
Tanggal konsultasi
Jam konsultasi
Topik konsultasi
Status
Catatan

Untuk ujikom, fitur laporan cukup dibuat dalam bentuk tabel saja. Tidak wajib export PDF/Excel jika waktunya terbatas.

Aktor Sistem
1. Admin

Admin memiliki akses untuk:

Mengelola data dosen
Mengelola jadwal konsultasi
Mengelola booking konsultasi
Mengubah status booking
Menghapus data booking
Melihat laporan
2. Mahasiswa

Mahasiswa memiliki akses untuk:

Melihat jadwal konsultasi
Mengisi form booking konsultasi
Melihat status booking

Untuk versi paling sederhana, mahasiswa tidak perlu login. Mahasiswa cukup mengisi form booking.

3. Dosen

Dosen memiliki akses untuk:

Melihat daftar booking konsultasi
Menyetujui atau menolak booking
Mengubah status menjadi selesai

Untuk versi ujikom yang simple, peran dosen bisa digabung dengan admin.

Struktur menu aplikasi

Panel Admin:
- Dashboard
- Data Dosen
- Booking Konsultasi (Pemantauan/Laporan Master)
- Laporan Booking

Panel Dosen:
- Dashboard (Statistik Dosen)
- Buka Bimbingan (Jadwal Konsultasi)
- Booking Masuk (Persetujuan Booking)

Panel Mahasiswa (Publik):
- Beranda (Form Booking via Modal)
- Lihat Jadwal (Daftar Jadwal + Form Booking Modal)
- Cek Status (Pencarian NIM via Navbar)

Kalau ingin ada tampilan mahasiswa:

Beranda
Lihat Jadwal
Booking Konsultasi
Cek Status Booking
Modul Minimal yang Wajib Dibuat

Kalau waktu pengerjaan mepet, cukup buat ini saja:

Modul Utama
Dashboard
Data Dosen
Jadwal Konsultasi
Booking Konsultasi

Itu sudah memenuhi CRUD karena ada:

Create: tambah data
Read: lihat data
Update: edit data/status
Delete: hapus data
Rancangan Database Sederhana
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
Alur Sistem Aplikasi
Admin login ke aplikasi
↓
Admin menginput data dosen
↓
Admin menginput jadwal konsultasi dosen
↓
Mahasiswa mengisi form booking konsultasi
↓
Sistem mengecek apakah jadwal bentrok atau tidak
↓
Jika tidak bentrok, data booking disimpan
↓
Status awal booking adalah Menunggu
↓
Admin/dosen memeriksa booking
↓
Admin/dosen mengubah status menjadi Disetujui, Ditolak, atau Selesai
↓
Data booking masuk ke laporan
Nama Modul untuk Ditulis di Dokumen Ujikom

Dokter bisa tulis seperti ini:

Modul sistem aplikasi yang dikembangkan terdiri atas modul dashboard, modul data dosen, modul jadwal konsultasi, modul booking konsultasi, modul validasi bentrok jadwal, modul pengelolaan status booking, dan modul laporan booking. Seluruh modul tersebut dirancang untuk mendukung proses manajemen jadwal dan booking konsultasi mahasiswa dengan dosen secara lebih terstruktur, terdokumentasi, dan mudah digunakan.

Masalah yang harus diselesaikan:

Konsultasi masih manual lewat chat pribadi.
Tidak ada pencatatan jadwal.
Sering bentrok waktu antara mahasiswa dan dosen.
Aplikasi harus bisa CRUD data booking.
Minimal fitur: tambah booking, tampilkan daftar booking, ubah status booking, hapus booking.
Menggunakan Laravel + Laragon, cukup aplikasi lokal/simple.
Ide aplikasi paling aman untuk ujikom

Buat aplikasi bernama:

SIBOKON — Sistem Booking Konsultasi Mahasiswa

Konsepnya sederhana: mahasiswa mengisi jadwal konsultasi, lalu admin/dosen bisa melihat daftar booking dan mengubah statusnya.

Status booking:

Menunggu
Disetujui
Ditolak
Selesai

Ini sudah sangat cocok dengan kriteria ujikom karena ada CRUD jelas dan kasusnya sesuai.

Fitur utama yang dibuat
1. Dashboard sederhana

Berisi ringkasan:

Total booking
Booking menunggu
Booking disetujui
Booking ditolak
Booking selesai

Tidak wajib, tapi bagus untuk tampilan.

2. CRUD Data Dosen

Data yang disimpan:

Nama dosen
NIP/NIDN
Keahlian/bidang
Email
No HP

Fitur:

Tambah dosen
Lihat dosen
Edit dosen
Hapus dosen
3. CRUD Jadwal Konsultasi

Data yang disimpan:

Dosen
Hari
Jam mulai
Jam selesai
Kuota
Keterangan

Contoh:

Dosen	Hari	Jam
Bu Rina	Senin	09.00–11.00
Pak Andi	Rabu	13.00–15.00

Fitur ini penting supaya terlihat aplikasi benar-benar mengatur jadwal.

4. CRUD Booking Konsultasi

Ini fitur paling utama.

Data booking:

Nama mahasiswa
NIM
Program studi
Dosen yang dipilih
Tanggal konsultasi
Jam konsultasi
Topik konsultasi
Status booking

Fitur:

Tambah booking
Lihat daftar booking
Edit booking
Ubah status booking
Hapus booking
5. Cegah bentrok jadwal sederhana

Tidak perlu terlalu rumit. Cukup buat validasi sederhana:

Jika dosen yang sama sudah memiliki booking pada tanggal dan jam yang sama, maka booking tidak boleh disimpan.

Contoh pesan:

“Jadwal sudah dibooking oleh mahasiswa lain. Silakan pilih waktu berbeda.”

Ini akan membuat aplikasi kamu terlihat sesuai masalah utama di kasus.

Struktur menu aplikasi

Sidebar atau navbar bisa dibuat seperti ini:

Dashboard
Data Dosen
Jadwal Konsultasi
Booking Konsultasi
Laporan Booking

Untuk junior web programmer, ini sudah cukup aman dan tidak terlalu ribet.

Struktur database yang simpel
Tabel dosens
Field	Tipe
id	bigint
nama_dosen	string
nidn	string
bidang_keahlian	string
email	string
no_hp	string
created_at	timestamp
updated_at	timestamp
Tabel jadwals
Field	Tipe
id	bigint
dosen_id	foreignId
hari	string
jam_mulai	time
jam_selesai	time
kuota	integer
keterangan	text
created_at	timestamp
updated_at	timestamp
Tabel bookings
Field	Tipe
id	bigint
nama_mahasiswa	string
nim	string
prodi	string
dosen_id	foreignId
tanggal	date
jam	time
topik	text
status	enum/string
created_at	timestamp
updated_at	timestamp
Alur sistem yang mudah dijelaskan saat ujikom
Admin membuka aplikasi.
Admin menambahkan data dosen.
Admin menambahkan jadwal konsultasi dosen.
Mahasiswa melakukan booking konsultasi.
Sistem menyimpan data booking.
Admin/dosen melihat daftar booking.
Admin/dosen mengubah status booking menjadi disetujui, ditolak, atau selesai.
Jika booking dibatalkan, data dapat dihapus.
Rekomendasi tampilan

Pakai yang simple saja:

Laravel Blade
Bootstrap 5
Table
Form input biasa
Tombol Tambah, Edit, Hapus, Detail
Badge status berwarna

Contoh status:

Menunggu: kuning
Disetujui: hijau
Ditolak: merah
Selesai: biru