<?php

namespace App\Filament\Resources\KodeBankResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\KodeBankResource;
use Konnco\FilamentImport\Actions\ImportField;
use Konnco\FilamentImport\Actions\ImportAction;

class ManageKodeBanks extends ManageRecords
{
    protected static string $resource = KodeBankResource::class;

    protected function getActions(): array
    {
        return [
            ImportAction::make()->fields([
                ImportField::make('kode_bank'),
                ImportField::make('nama_bank'),
            ]),
            Actions\CreateAction::make(),
        ];
    }
}
