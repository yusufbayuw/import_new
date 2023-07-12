<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use App\Models\KodeKecamatan;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\KodeKecamatanResource\Pages;
use App\Filament\Resources\KodeKecamatanResource\RelationManagers;

class KodeKecamatanResource extends Resource
{
    protected static ?string $model = KodeKecamatan::class;

    protected static ?int $navigationSort = 17;

    protected static ?string $modelLabel = 'Kode Kecamatan';

    protected static ?string $navigationIcon = 'heroicon-o-location-marker';

    protected static ?string $slug = 'kode-kecamatan';

    protected static ?string $navigationLabel = 'Kode Kecamatan';

    protected static ?string $navigationGroup = 'Data Import';
    
    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->fastPaginate($this->getTableRecordsPerPage());
    }
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode_kecamatan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_kecamatan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_dati2')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_operasional')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_kecamatan')->sortable(),
                Tables\Columns\TextColumn::make('nama_kecamatan')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('nama_dati2')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('nama_operasional')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ManageKodeKecamatans::route('/'),
        ];
    }  

}
