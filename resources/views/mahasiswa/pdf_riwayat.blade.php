<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Lembar Bimbingan Laporan Akhir</title>
    <style>
        @page {
            margin: 15mm 15mm 15mm 15mm;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            color: #000;
            margin: 0;
            padding: 0;
        }
        .kop-surat {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }
        .kop-surat img {
            width: 100%;
            max-height: 90px;
        }
        .kop-text h2 {
            margin: 3px 0 1px 0;
            font-size: 14pt;
            font-weight: bold;
        }
        .kop-text h3 {
            margin: 0 0 1px 0;
            font-size: 12pt;
            font-weight: bold;
        }
        .kop-text p {
            margin: 0;
            font-size: 9pt;
        }
        .judul-surat {
            text-align: center;
            margin: 12px 0 8px 0;
        }
        .judul-surat h4 {
            font-size: 12pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 0;
        }
        .lembar-no {
            text-align: right;
            font-size: 10pt;
            margin-bottom: 5px;
        }
        .data-mahasiswa {
            width: 100%;
            margin-bottom: 10px;
        }
        .data-mahasiswa td {
            padding: 2px 5px;
            font-size: 10pt;
            vertical-align: top;
        }
        .data-mahasiswa td.label-col {
            width: 150px;
            font-weight: bold;
        }
        .data-mahasiswa td.sep {
            width: 10px;
        }
        .bimbingan-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
            margin-top: 8px;
        }
        .bimbingan-table th, .bimbingan-table td {
            border: 1px solid #000;
            padding: 4px 6px;
        }
        .bimbingan-table th {
            background-color: #e8e8e8;
            text-align: center;
            font-weight: bold;
            font-size: 9pt;
        }
        .bimbingan-table td.center {
            text-align: center;
        }
        .bimbingan-table td.no-col {
            text-align: center;
            width: 25px;
        }
        .bimbingan-table td.tgl-col {
            text-align: center;
            width: 70px;
        }
        .bimbingan-table td.ttd-col {
            width: 80px;
            text-align: center;
        }
        .ttd-area {
            margin-top: 20px;
            width: 100%;
        }
        .ttd-area td {
            vertical-align: top;
            font-size: 10pt;
        }
        .catatan {
            margin-top: 15px;
            font-size: 9pt;
        }
        .catatan p {
            margin: 1px 0;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    {{-- ===== HALAMAN 1: Baris 1–6 ===== --}}
    @php
        $kopPath = public_path('images/kop-surat.png');
        $hasKop = file_exists($kopPath);
        $kopBase64 = '';
        if ($hasKop) {
            $type = pathinfo($kopPath, PATHINFO_EXTENSION);
            $data = file_get_contents($kopPath);
            $kopBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
        $totalRows = 22;
        $firstPageRows = 6;
        $secondPageRows = $totalRows - $firstPageRows;
    @endphp

    {{-- Kop Surat --}}
    <div class="kop-surat">
        @if($hasKop)
            <img src="{{ $kopBase64 }}" alt="Kop Surat">
        @else
            <div class="kop-text">
                <h2>KEMENTERIAN PENDIDIKAN TINGGI, SAINS, DAN TEKNOLOGI</h2>
                <h3>POLITEKNIK NEGERI SRIWIJAYA</h3>
                <p>Jalan Srijaya Negara Bukit Besar - Palembang 30139</p>
                <p>Telepon 0711-353414 Faksimili 0711-355918</p>
                <p>Laman : http://polsri.ac.id &nbsp; Pos El : info@polsri.ac.id</p>
            </div>
        @endif
    </div>

    {{-- Judul --}}
    <div class="judul-surat">
        <h4>LEMBAR BIMBINGAN LAPORAN AKHIR</h4>
    </div>
    <div class="lembar-no">Lembar : 1</div>

    {{-- Data Mahasiswa --}}
    <table class="data-mahasiswa">
        <tr>
            <td class="label-col">Nama</td>
            <td class="sep">:</td>
            <td>{{ $mahasiswa->nama_mahasiswa ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-col">NPM</td>
            <td class="sep">:</td>
            <td>{{ $mahasiswa->nim ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-col">Jurusan/Program Studi</td>
            <td class="sep">:</td>
            <td>Manajemen Informatika / {{ $mahasiswa->prodi ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-col">Judul Laporan Akhir</td>
            <td class="sep">:</td>
            <td>{{ $mahasiswa->judul_ta ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-col">Pembimbing {{ $pembimbingKe }} *)</td>
            <td class="sep">:</td>
            <td>{{ $dosen->nama_dosen ?? '-' }}</td>
        </tr>
    </table>

    {{-- Tabel Bimbingan Halaman 1 (No 1–6) --}}
    <table class="bimbingan-table">
        <thead>
            <tr>
                <th style="width:25px;">No.</th>
                <th style="width:70px;">Tanggal</th>
                <th>Uraian Bimbingan</th>
                <th style="width:80px;">Tanda Tangan<br>Pembimbing</th>
            </tr>
        </thead>
        <tbody>
            @for($row = 0; $row < $firstPageRows; $row++)
                <tr style="height: 45px;">
                    <td class="no-col">{{ $row + 1 }}.</td>
                    <td class="tgl-col">
                        @if(isset($bookings[$row]))
                            {{ \Carbon\Carbon::parse($bookings[$row]->tanggal)->format('d-m-Y') }}
                        @endif
                    </td>
                    <td>
                        @if(isset($bookings[$row]) && $bookings[$row]->uraian)
                            {{ $bookings[$row]->uraian }}
                        @endif
                    </td>
                    <td class="ttd-col"></td>
                </tr>
            @endfor
        </tbody>
    </table>

    {{-- ===== HALAMAN 2: Baris 7–22 + TTD ===== --}}
    <div class="page-break"></div>

    {{-- Kop Surat Halaman 2 --}}
    <div class="kop-surat">
        @if($hasKop)
            <img src="{{ $kopBase64 }}" alt="Kop Surat">
        @else
            <div class="kop-text">
                <h2>KEMENTERIAN PENDIDIKAN TINGGI, SAINS, DAN TEKNOLOGI</h2>
                <h3>POLITEKNIK NEGERI SRIWIJAYA</h3>
                <p>Jalan Srijaya Negara Bukit Besar - Palembang 30139</p>
                <p>Telepon 0711-353414 Faksimili 0711-355918</p>
                <p>Laman : http://polsri.ac.id &nbsp; Pos El : info@polsri.ac.id</p>
            </div>
        @endif
    </div>

    <div class="lembar-no">Lembar : 2</div>

    {{-- Tabel Bimbingan Halaman 2 (No 7–22) --}}
    <table class="bimbingan-table">
        <thead>
            <tr>
                <th style="width:25px;">No.</th>
                <th style="width:70px;">Tanggal</th>
                <th>Uraian Bimbingan</th>
                <th style="width:80px;">Tanda Tangan<br>Pembimbing</th>
            </tr>
        </thead>
        <tbody>
            @for($row = $firstPageRows; $row < $totalRows; $row++)
                <tr style="height: 30px;">
                    <td class="no-col">{{ $row + 1 }}.</td>
                    <td class="tgl-col">
                        @if(isset($bookings[$row]))
                            {{ \Carbon\Carbon::parse($bookings[$row]->tanggal)->format('d-m-Y') }}
                        @endif
                    </td>
                    <td>
                        @if(isset($bookings[$row]) && $bookings[$row]->uraian)
                            {{ $bookings[$row]->uraian }}
                        @endif
                    </td>
                    <td class="ttd-col"></td>
                </tr>
            @endfor
        </tbody>
    </table>

    {{-- Tanda Tangan Ketua Jurusan --}}
    <table class="ttd-area">
        <tr>
            <td style="width: 55%;"></td>
            <td style="text-align: center;">
                <p>Palembang, {{ now()->translatedFormat('d F Y') }}</p>
                <p>Ketua Jurusan,</p>
                <br><br><br>
                <p style="text-decoration: underline; font-weight: bold;">{{ $ketuaNama }}</p>
                <p>NIP. {{ $ketuaNip }}</p>
            </td>
        </tr>
    </table>

    {{-- Catatan --}}
    <div class="catatan">
        <p><strong>Catatan:</strong></p>
        <p>*) melingkari angka yang sesuai.</p>
        <p>Ketua Jurusan harus memeriksa jumlah pelaksanaan bimbingan sesuai yang dipersyaratkan dalam Pedoman Laporan Akhir sebelum menandatangani lembar bimbingan ini.</p>
        <p>Lembar pembimbingan LA ini harus dilampirkan dalam Laporan Akhir.</p>
    </div>
</body>
</html>
