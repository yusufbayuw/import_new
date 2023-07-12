<?php

namespace App\Filament\Resources\KodeKecamatanResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Konnco\FilamentImport\Actions\ImportField;
use Konnco\FilamentImport\Actions\ImportAction;
use App\Filament\Resources\KodeKecamatanResource;

class ManageKodeKecamatans extends ManageRecords
{
    protected static string $resource = KodeKecamatanResource::class;

    protected function getActions(): array
    {
        return [
            ImportAction::make()->fields([
                ImportField::make('kode_kecamatan'),
                ImportField::make('nama_kecamatan'),
                ImportField::make('nama_dati2'),
                ImportField::make('nama_operasional')
            ]),
            Actions\CreateAction::make(),
        ];
    }
}
