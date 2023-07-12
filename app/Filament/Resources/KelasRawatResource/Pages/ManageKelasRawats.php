<?php

namespace App\Filament\Resources\KelasRawatResource\Pages;

use App\Filament\Resources\KelasRawatResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageKelasRawats extends ManageRecords
{
    protected static string $resource = KelasRawatResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
