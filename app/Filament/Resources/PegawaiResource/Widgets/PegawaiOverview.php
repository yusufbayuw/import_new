<?php

namespace App\Filament\Resources\PegawaiResource\Widgets;

use Filament\Widgets\Widget;

class PegawaiOverview extends Widget
{
    protected int | string | array $columnSpan = 'full';
    
    protected static string $view = 'filament.resources.pegawai-resource.widgets.pegawai-overview';

    public $rekap;

    public function mount()
    {
        $pegawai = \App\Models\Pegawai::withCount('mutasi')->get();

        // Rekap berdasarkan unit
        $this->rekap = $pegawai->groupBy('unit')->map(function ($group) {
            return $group->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nip' => $item->nip,
                    'nama' => $item->nama,
                    'unit' => $item->unit,
                    'mutasi_count' => $item->mutasi_count,
                    'is_tetap' => $item->is_tetap,
                ];
            });
        });
    }
}
