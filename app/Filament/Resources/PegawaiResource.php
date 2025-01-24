<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PegawaiResource\Pages;
use App\Filament\Resources\PegawaiResource\RelationManagers;
use App\Models\Pegawai;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PegawaiResource extends Resource
{
    protected static ?string $model = Pegawai::class;

    protected static ?int $navigationSort = 10;

    protected static ?string $modelLabel = 'Data Pegawai';

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $slug = 'pegawai';

    protected static ?string $navigationLabel = 'Data Pegawai';

    protected static ?string $navigationGroup = 'Data List';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nip')
                    ->maxLength(255)
                    ->label('NIP'),
                Forms\Components\TextInput::make('nama')
                    ->label('NAMA')
                    ->maxLength(255),
                Forms\Components\Select::make('unit')
                    ->label('UNIT')
                    ->options([
                        "TK" => "TK",
                        "SD" => "SD",
                        "SMP" => "SMP",
                        "SMA" => "SMA",
                        "TBU" => "TBU",
                        "ADM" => "ADM",
                    ]),
                Forms\Components\Toggle::make('is_tetap')
                    ->label('TETAP'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nip')
                    ->label('NIP')
                    ->copyable()
                    ->copyMessage("NIP disalin 👍")
                    ->searchable(),
                Tables\Columns\SelectColumn::make('unit')
                    ->label('UNIT')
                    ->options([
                        "TK" => "TK",
                        "SD" => "SD",
                        "SMP" => "SMP",
                        "SMA" => "SMA",
                        "TBU" => "TBU",
                        "ADM" => "ADM",
                    ]),
                Tables\Columns\TextColumn::make('nama')
                    ->label('Pegawai')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_tetap')->label('Tetap?')
                    ->boolean(),
                Tables\Columns\TextColumn::make('mutasi_count')->counts('mutasi')->sortable()
                    ->label('MUTASI'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPegawais::route('/'),
            'create' => Pages\CreatePegawai::route('/create'),
            'edit' => Pages\EditPegawai::route('/{record}/edit'),
        ];
    }
}
