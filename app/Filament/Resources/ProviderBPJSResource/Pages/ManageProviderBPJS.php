<?php

namespace App\Filament\Resources\ProviderBPJSResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Konnco\FilamentImport\Actions\ImportField;
use Konnco\FilamentImport\Actions\ImportAction;
use App\Filament\Resources\ProviderBPJSResource;

class ManageProviderBPJS extends ManageRecords
{
    protected static string $resource = ProviderBPJSResource::class;

    protected function getActions(): array
    {
        return [
            ImportAction::make()->fields([
                ImportField::make('kode_ppk_bpjs'),
                ImportField::make('nama_ppk_bpjs'),
                ImportField::make('tipe_ppk_bpjs'),
                ImportField::make('alamat'),
                ImportField::make('nama_dati2_ppk'),
                ImportField::make('provinsi'),
                ImportField::make('kode_ppk_inh'),
                ImportField::make('active'),
            ]),
            Actions\CreateAction::make(),
        ];
    }
}
