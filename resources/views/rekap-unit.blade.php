<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Pegawai Berdasarkan Unit</title>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 16px;
        }
        thead {
            background-color: #343a40;
            color: white;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .bg-red {
            background-color: #ff747f;
        }
        .bg-yellow {
            background-color: #ffc400;
        }
        .bg-green {
            background-color: #ffffff;
        }
        }
    </style>
</head>
<body>
    <div class="container">

        <!-- Tabel Rekap Unit -->
        <h2 style="text-align: center; margin-top: 40px;">Rekapitulasi Unit</h2>
        <table>
            <thead>
                <tr>
                    <th>Unit</th>
                    <th>Total Pegawai</th>
                    <th>Sudah Mengisi</th>
                    <th>Belum Mengisi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $units = ['TK', 'SD', 'SMP', 'SMA', 'TBU', 'ADM'];
                @endphp
                @foreach ($units as $unit)
                    @php
                        $totalPegawai = $rekap[$unit]->count() ?? 0;
                        $sudahMengisi = $rekap[$unit]->filter(fn($p) => $p['mutasi_count'] > 0)->count() ?? 0;
                        $belumMengisi = $totalPegawai - $sudahMengisi;
                    @endphp
                    <tr>
                        <td>{{ $unit }}</td>
                        <td>{{ $totalPegawai }}</td>
                        <td>{{ $sudahMengisi }}</td>
                        <td>{{ $belumMengisi }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h1 style="text-align: center; margin-bottom: 20px;">Rekapitulasi Pegawai Berdasarkan Unit</h1>

        <!-- Tabel Rekap Pegawai -->
        <table>
            <thead>
                <tr>
                    <th>Unit</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Jumlah Mutasi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rekap as $unit => $pegawai)
                    @foreach ($pegawai as $item)
                        <tr class="
                            @if ($item['mutasi_count'] == 0) bg-red
                            @elseif ($item['mutasi_count'] > 4) bg-yellow
                            @else bg-green
                            @endif">
                            <td>{{ $unit }}</td>
                            <td>{{ $item['nip'] }}</td>
                            <td>{{ $item['nama'] }}</td>
                            <td>{{ $item['mutasi_count'] }}</td>
                            <td>{{ $item['is_tetap'] ? 'Tetap' : 'Kontrak' }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
