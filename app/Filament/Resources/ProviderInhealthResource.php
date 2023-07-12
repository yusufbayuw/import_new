<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Models\ProviderInhealth;
use Filament\Resources\Resource;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProviderInhealthResource\Pages;
use App\Filament\Resources\ProviderInhealthResource\RelationManagers;

class ProviderInhealthResource extends Resource
{
    protected static ?string $model = ProviderInhealth::class;

    protected static ?int $navigationSort = 19;

    protected static ?string $modelLabel = 'Provider InHealth';

    protected static ?string $navigationIcon = 'heroicon-o-view-grid';

    protected static ?string $slug = 'provider-inhealth';

    protected static ?string $navigationLabel = 'Provider InHealth';

    protected static ?string $navigationGroup = 'Data Import';
    
    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->fastPaginate($this->getTableRecordsPerPage());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode_provider')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_provider')
                    ->maxLength(255),
                Forms\Components\TextInput::make('alamat')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kantor_operasional')
                    ->maxLength(255),
                Forms\Components\TextInput::make('wilayah_pelayanan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('dati2')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_provider')->sortable(),
                Tables\Columns\TextColumn::make('nama_provider')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('alamat')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('kantor_operasional')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('wilayah_pelayanan')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('dati2')->searchable()->sortable(),
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
            'index' => Pages\ManageProviderInhealths::route('/'),
        ];
    }    
}
