<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Booking SIBOKO</title>
    <style>
        @page {
            margin: 20mm 15mm 20mm 15mm;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            color: #000;
            margin: 0;
            padding: 0;
        }
        .kop-surat {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .kop-surat img {
            width: 100%;
            max-height: 100px;
        }
        .kop-surat h2 {
            margin: 5px 0 2px 0;
            font-size: 16pt;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .kop-surat h3 {
            margin: 0 0 2px 0;
            font-size: 13pt;
            font-weight: bold;
        }
        .kop-surat p {
            margin: 0;
            font-size: 10pt;
        }
        .judul-surat {
            text-align: center;
            margin: 20px 0 15px 0;
        }
        .judul-surat h4 {
            font-size: 13pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 0;
        }
        .filter-info {
            width: 100%;
            margin-bottom: 15px;
        }
        .filter-info td {
            padding: 3px 8px;
            font-size: 11pt;
            vertical-align: top;
        }
        .filter-info td.label-col {
            width: 130px;
            font-weight: bold;
        }
        .filter-info td.sep {
            width: 10px;
        }
        .laporan-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
            margin-top: 10px;
        }
        .laporan-table th, .laporan-table td {
            border: 1px solid #000;
            padding: 4px 6px;
        }
        .laporan-table th {
            background-color: #e0e0e0;
            text-align: center;
            font-weight: bold;
        }
        .laporan-table td.center {
            text-align: center;
        }
        .ttd-area {
            margin-top: 30px;
            width: 100%;
        }
        .ttd-area td {
            vertical-align: top;
            font-size: 11pt;
        }
    </style>
</head>
<body>
    @php
        $kopPath = public_path('images/kop-surat.png');
        $hasKop = file_exists($kopPath);
        $kopBase64 = '';
        if ($hasKop) {
            $type = pathinfo($kopPath, PATHINFO_EXTENSION);
            $imgData = file_get_contents($kopPath);
            $kopBase64 = 'data:image/' . $type . ';base64,' . base64_encode($imgData);
        }
    @endphp

    {{-- Kop Surat --}}
    <div class="kop-surat">
        @if($hasKop)
            <img src="{{ $kopBase64 }}" alt="Kop Surat">
        @else
            <h2>KEMENTERIAN PENDIDIKAN TINGGI, SAINS, DAN TEKNOLOGI</h2>
            <h3>POLITEKNIK NEGERI SRIWIJAYA</h3>
            <p>Jalan Srijaya Negara Bukit Besar - Palembang 30139</p>
            <p>Telepon 0711-353414 Faksimili 0711-355918</p>
            <p>Laman : http://polsri.ac.id &nbsp; Pos El : info@polsri.ac.id</p>
        @endif
    </div>

    {{-- Judul --}}
    <div class="judul-surat">
        <h4>LAPORAN BOOKING KONSULTASI</h4>
    </div>

    {{-- Info Filter: Prodi, Periode, Status --}}
    <table class="filter-info">
        <tr>
            <td class="label-col">Program Studi</td>
            <td class="sep">:</td>
            <td>{{ $prodi }}</td>
        </tr>
        <tr>
            <td class="label-col">Periode</td>
            <td class="sep">:</td>
            <td>{{ $bulan }}</td>
        </tr>
        <tr>
            <td class="label-col">Status</td>
            <td class="sep">:</td>
            <td>{{ $status ?? 'Semua Status' }}</td>
        </tr>
    </table>

    {{-- Tabel Laporan --}}
    <table class="laporan-table">
        <thead>
            <tr>
                <th style="width: 25px;">No</th>
                <th>Mahasiswa</th>
                <th style="width: 70px;">NIM</th>
                <th>Prodi</th>
                <th>Dosen</th>
                <th style="width: 70px;">Tanggal</th>
                <th style="width: 40px;">Jam</th>
                <th style="width: 55px;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $i => $b)
            <tr>
                <td class="center">{{ $i + 1 }}</td>
                <td>{{ $b->nama_mahasiswa }}</td>
                <td class="center">{{ $b->nim }}</td>
                <td>{{ $b->prodi }}</td>
                <td>{{ $b->dosen->nama_dosen ?? '-' }}</td>
                <td class="center">{{ \Carbon\Carbon::parse($b->tanggal)->format('d/m/Y') }}</td>
                <td class="center">{{ \Carbon\Carbon::parse($b->jam)->format('H:i') }}</td>
                <td class="center">{{ $b->status }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="center">Tidak ada data laporan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Tanda Tangan --}}
    <table class="ttd-area">
        <tr>
            <td style="width: 50%;"></td>
            <td style="text-align: center;">
                <p>Palembang, {{ now()->translatedFormat('d F Y') }}</p>
                <p>Administrator,</p>
                <br><br><br>
                <p style="text-decoration: underline; font-weight: bold;">Administrator SIBOKO</p>
                <p>NIP. ____________________</p>
            </td>
        </tr>
    </table>
</body>
</html>
