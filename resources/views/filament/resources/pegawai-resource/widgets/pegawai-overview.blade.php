<x-filament::widget>
    <x-filament::card>
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
    </x-filament::card>
</x-filament::widget>
