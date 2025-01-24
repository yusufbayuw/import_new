<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Pegawai Berdasarkan Unit</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .table-hover tbody tr:hover {
            background-color: #e9ecef;
        }
        .thead-dark th {
            text-align: center;
            background-color: #343a40;
            color: #fff;
        }
        .bg-red {
            background-color: #f8d7da !important;
        }
        .bg-yellow {
            background-color: #fff3cd !important;
        }
        .bg-green {
            background-color: #d4edda !important;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Rekapitulasi Pegawai Berdasarkan Unit</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Unit</th>
                        <th>ID</th>
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
                                <td>{{ $item['id'] }}</td>
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
    </div>
</body>
</html>
