<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\ProviderBPJS;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProviderBPJSResource\Pages;
use App\Filament\Resources\ProviderBPJSResource\RelationManagers;

class ProviderBPJSResource extends Resource
{
    protected static ?string $model = ProviderBPJS::class;

    protected static ?int $navigationSort = 18;

    protected static ?string $modelLabel = 'Provider BPJS';

    protected static ?string $navigationIcon = 'heroicon-o-view-list';

    protected static ?string $slug = 'provider-bpjs';

    protected static ?string $navigationLabel = 'Provider BPJS';

    protected static ?string $navigationGroup = 'Data Import';
    
    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->fastPaginate($this->getTableRecordsPerPage());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode_ppk_bpjs')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_ppk_bpjs')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tipe_ppk_bpjs')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('alamat')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_dati2_ppk')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('provinsi')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('kode_ppk_inh')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_ppk_bpjs')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('nama_ppk_bpjs')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('tipe_ppk_bpjs')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('alamat')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('nama_dati2_ppk')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('provinsi')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('kode_ppk_inh')->toggleable(isToggledHiddenByDefault: true)->searchable()->sortable(),
                Tables\Columns\IconColumn::make('active')
                    ->boolean()->sortable(),
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
            'index' => Pages\ManageProviderBPJS::route('/'),
        ];
    }    
}
