<?php

namespace App\Filament\Resources\PegawaiResource\Pages;

use Closure;
use Filament\Pages\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PegawaiResource;
use App\Models\Pegawai;
use Konnco\FilamentImport\Actions\ImportField;
use Konnco\FilamentImport\Actions\ImportAction;

class ListPegawais extends ListRecords
{
    protected static string $resource = PegawaiResource::class;

    protected function getActions(): array
    {
        return [
            ImportAction::make()->fields([
                ImportField::make('nip'),
                ImportField::make('nama'),
                ImportField::make('is_tetap'),
            ]),
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PegawaiResource\Widgets\PegawaiOverview::class,
        ];
    }

    protected function getTableRecordClassesUsing(): ?Closure
    {
        return function (Pegawai $record) {
            if ($record->mutasi_count > 4) {
                return 'border-l-2 border-r-0 border-t-0 border-b-0 border-orange-600 bg-orange-100'; // warna warning (border dan background)
            } elseif ($record->mutasi_count == 0) {
                return 'border-l-2  border-r-0 border-t-0 border-b-0 border-red-600 bg-red-100'; // warna danger (border dan background)
            } else {
                return null; // warna default untuk kondisi lainnya
            }
        };
    }
}
