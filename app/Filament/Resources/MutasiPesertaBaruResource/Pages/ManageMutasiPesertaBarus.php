<?php

namespace App\Filament\Resources\MutasiPesertaBaruResource\Pages;

use App\Filament\Resources\MutasiPesertaBaruResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMutasiPesertaBarus extends ManageRecords
{
    protected static string $resource = MutasiPesertaBaruResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
