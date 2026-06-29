<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kartu Rencana Studi (KRS)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
        }
        .header p {
            margin: 4px 0 0 0;
            font-size: 11px;
            color: #555;
        }
        .title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 20px;
            text-decoration: underline;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
        }
        .meta-table td {
            padding: 3px 0;
            vertical-align: top;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .data-table th {
            background-color: #f2f2f2;
            border: 1px solid #666;
            padding: 8px;
            font-size: 11px;
            text-transform: uppercase;
            text-align: left;
        }
        .data-table td {
            border: 1px solid #666;
            padding: 7px 8px;
            font-size: 11px;
        }
        .text-center {
            text-align: center;
        }
        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .ttd-container {
            margin-top: 40px;
            width: 100%;
        }
        .ttd-box {
            width: 45%;
            float: right;
            text-align: center;
        }
        .ttd-space {
            height: 65px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>UNIVERSITAS BONJOVI</h2>
        <h2>FAKULTAS TEKNIK</h2>
        <p>Jl. Pasir Kuray Telp. (0263) 283578 Cianjur 43283</p>
    </div>

    <div class="title">KARTU RENCANA STUDI (KRS)</div>

    <table class="meta-table">
        <tr>
            <td style="width: 18%;">Nama Mahasiswa</td>
            <td style="width: 2%;">:</td>
            <td style="width: 40%; font-weight: bold;">{{ $nama }}</td>
            <td style="width: 15%;">Tahun Akademik</td>
            <td style="width: 2%;">:</td>
            <td style="width: 23%;">2025/2026</td>
        </tr>
        <tr>
            <td>NPM</td>
            <td>:</td>
            <td>{{ $npm }}</td>
            <td>Semester</td>
            <td>:</td>
            <td>Genap</td>
        </tr>
        <tr>
            <td>Program Studi</td>
            <td>:</td>
            <td>Teknik Informatika</td>
            <td>Status Kelulusan</td>
            <td>:</td>
            <td style="color: green; font-weight: bold;">Disetujui</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 8%;" class="text-center">No</th>
                <th style="width: 20%;">Kode MK</th>
                <th style="width: 57%;">Nama Mata Kuliah</th>
                <th style="width: 15%;" class="text-center">SKS</th>
            </tr>
        </thead>
        <tbody>
            @forelse($krsDiambil as $index => $k)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $k->kode_matakuliah }}</td>
                    <td>{{ $k->matakuliah->nama_matakuliah }}</td>
                    <td class="text-center">{{ $k->matakuliah->sks }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center" style="padding: 15px; color: #777;">
                        Belum ada data mata kuliah yang terdaftar/di-apply di dalam database.
                    </td>
                </tr>
            @endforelse
            
            <tr class="total-row">
                <td colspan="3" style="text-align: right; padding-right: 15px;">TOTAL BEBAN BEBAN SKS AMBILAN:</td>
                <td class="text-center" style="font-size: 13px; font-weight: bold;">{{ $totalSks }}</td>
            </tr>
        </tbody>
    </table>

    <div class="ttd-container">
        <div class="ttd-box">
            <p>Cianjur, {{ $tanggal }}</p>
            <p>Dosen Wali,</p>
            <div class="ttd-space"></div>
            <p style="text-decoration: underline; font-weight: bold;">Jajang Dangin S, ST., M.Kom</p>
            <p style="font-size: 10px; color: #555;">NIDN. 0444098501</p>
        </div>
        <div style="clear: both;"></div>
    </div>

</body>
</html>