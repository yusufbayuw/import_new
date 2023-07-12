<?php

namespace App\Filament\Resources\StatusKawinResource\Pages;

use App\Filament\Resources\StatusKawinResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageStatusKawins extends ManageRecords
{
    protected static string $resource = StatusKawinResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
