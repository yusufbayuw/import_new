<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Pisa;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PisaResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PisaResource\RelationManagers;

class PisaResource extends Resource
{
    protected static ?string $model = Pisa::class;

    protected static ?int $navigationSort = 10;

    protected static ?string $modelLabel = 'Data Keluarga';

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $slug = 'pisa';

    protected static ?string $navigationLabel = 'Data Keluarga';

    protected static ?string $navigationGroup = 'Data List';
    
    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->fastPaginate($this->getTableRecordsPerPage());
    }
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode'),
                Tables\Columns\TextColumn::make('nama'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()->toggleable(isToggledHiddenByDefault: true)->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()->toggleable(isToggledHiddenByDefault: true)->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePisas::route('/'),
        ];
    }    
}
