<x-filament::widget>
    <x-filament::card>
        <table style="border-collapse: collapse; width: 100%; border: 1px solid black;">
            <thead>
                <tr>
                    <th style="border: 1px solid black; padding: 8px;">Unit</th>
                    <th style="border: 1px solid black; padding: 8px;">Total Pegawai</th>
                    <th style="border: 1px solid black; padding: 8px;">Sudah Mengisi</th>
                    <th style="border: 1px solid black; padding: 8px;">Belum Mengisi</th>
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
                        <td style="border: 1px solid black; padding: 8px;">{{ $unit }}</td>
                        <td style="border: 1px solid black; padding: 8px;">{{ $totalPegawai }}</td>
                        <td style="border: 1px solid black; padding: 8px;">{{ $sudahMengisi }}</td>
                        <td style="border: 1px solid black; padding: 8px;">{{ $belumMengisi }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
    </x-filament::card>
</x-filament::widget>
