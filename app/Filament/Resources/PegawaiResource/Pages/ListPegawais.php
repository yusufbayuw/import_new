<?php

namespace App\Filament\Resources\PegawaiResource\Pages;

use Closure;
use Filament\Pages\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PegawaiResource;
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
        return fn(Model $record) => match ($record->status) {
            'draft' => 'opacity-30',
            'reviewing' => [
                'border-l-2 border-orange-600',
                'dark:border-orange-300' => config('tables.dark_mode'),
            ],
            'published' => 'border-l-2 border-green-600',
            default => null,
        };
    }
}
