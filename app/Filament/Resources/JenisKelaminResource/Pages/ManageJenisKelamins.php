<?php

namespace App\Filament\Resources\JenisKelaminResource\Pages;

use App\Filament\Resources\JenisKelaminResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageJenisKelamins extends ManageRecords
{
    protected static string $resource = JenisKelaminResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
