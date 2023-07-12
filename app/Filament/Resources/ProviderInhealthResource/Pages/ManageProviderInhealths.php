<?php

namespace App\Filament\Resources\ProviderInhealthResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords; 
use Konnco\FilamentImport\Actions\ImportField;
use Konnco\FilamentImport\Actions\ImportAction;
use App\Filament\Resources\ProviderInhealthResource;

class ManageProviderInhealths extends ManageRecords
{
    protected static string $resource = ProviderInhealthResource::class;

    protected function getActions(): array
    {
        return [
            ImportAction::make()->fields([
                ImportField::make('kode_provider'),
                ImportField::make('nama_provider'),
                ImportField::make('alamat'),
                ImportField::make('kantor_operasional'),
                ImportField::make('wilayah_pelayanan'),
                ImportField::make('dati2'),
            ]),
            Actions\CreateAction::make(),
        ];
    }
}
