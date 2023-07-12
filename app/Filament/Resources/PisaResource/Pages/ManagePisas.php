<?php

namespace App\Filament\Resources\PisaResource\Pages;

use App\Filament\Resources\PisaResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePisas extends ManageRecords
{
    protected static string $resource = PisaResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
