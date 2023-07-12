<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\KodeBank;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\KodeBankResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\KodeBankResource\RelationManagers;

class KodeBankResource extends Resource
{
    protected static ?string $model = KodeBank::class;

    protected static ?int $navigationSort = 16;

    protected static ?string $modelLabel = 'Kode Bank';

    protected static ?string $navigationIcon = 'heroicon-o-library';

    protected static ?string $slug = 'kode-bank';

    protected static ?string $navigationLabel = 'Kode Bank';

    protected static ?string $navigationGroup = 'Data Import';
    
    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->fastPaginate($this->getTableRecordsPerPage());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode_bank')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_bank')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_bank')->sortable(),
                Tables\Columns\TextColumn::make('nama_bank')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ManageKodeBanks::route('/'),
        ];
    }    
}
