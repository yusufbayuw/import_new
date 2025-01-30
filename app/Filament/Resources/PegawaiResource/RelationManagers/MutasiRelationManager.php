<?php

namespace App\Filament\Resources\PegawaiResource\RelationManagers;

use Closure;
use stdClass;
use Filament\Forms;
use App\Models\Pisa;
use Filament\Tables;
use App\Models\Produk;
use App\Models\Jabatan;
use App\Models\KodeBank;
use App\Models\KelasRawat;
use App\Models\StatusKawin;
use App\Models\JenisKelamin;
use App\Models\ProviderBPJS;
use Filament\Resources\Form;
use App\Models\KodeKecamatan;
use Filament\Resources\Table;
use App\Models\ProviderInhealth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class MutasiRelationManager extends RelationManager
{
    protected static string $relationship = 'mutasi';

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Identitas')
                    ->schema([
                        TextInput::make('nama')->label('Nama')->required()->extraInputAttributes(['onChange' => 'this.value = this.value.toUpperCase()'])->dehydrateStateUsing(fn($state) => strtoupper($state)),
                        TextInput::make('email')->email()->required(),
                        TextInput::make('nomor_induk_kependudukan')->label('Nomor Induk Kependudukan (NIK)')->numeric()->length(16)->required(),
                        TextInput::make('no_peg')->label('Nomor Induk Pegawai (NIP)')
                            ->required(),
                        Select::make('jabatan')->options(Jabatan::all()->pluck('nama', 'kode'))->searchable()->label('Jabatan')->preload()->required(),
                        TextInput::make('no_telepon')->label('Nomor Telepon')->numeric()->required(),
                        Hidden::make('sub_group')->default(''),
                        Hidden::make('nama_subgroup')->default(''),
                        TextInput::make('tempat_lhr')->label('Tempat Kelahiran')->extraInputAttributes(['onChange' => 'this.value = this.value.toUpperCase()'])->dehydrateStateUsing(fn($state) => strtoupper($state))->required(),
                        DatePicker::make('tgl_lhr')->label('Tanggal Lahir')->required(),
                        Select::make('jns_kel')->options(JenisKelamin::all()->pluck('nama', 'kode'))->label('Jenis Kelamin')->required(),
                    ]),
                Section::make('Status')
                    ->schema([
                        Select::make('pisa')->options(Pisa::all()->pluck('nama', 'kode'))->label('Status di Kartu Keluarga')->required(),
                        Select::make('status_kawin')->options(StatusKawin::all()->pluck('nama', 'kode'))->label('Status Perkawinan')->required(),
                        TextInput::make('alamat')->label('Alamat Lengkap')->extraInputAttributes(['onChange' => 'this.value = this.value.toUpperCase()'])->dehydrateStateUsing(fn($state) => strtoupper($state))->required(),
                        Select::make('kode_kecamatan')->options(KodeKecamatan::all()->pluck('nama_kecamatan', 'kode_kecamatan'))->searchable()->label('Nama Kecamatan')->required(),
                        Select::make('nama_bank')->options(KodeBank::all()->pluck('nama_bank', 'nama_bank'))->searchable()->preload()->label('Nama Bank yang Digunakan')
                            ->reactive()
                            ->required()
                            ->afterStateUpdated(function (Closure $set, $state) {
                                if ($state) {
                                    $set('kode_bank', KodeBank::where('nama_bank', $state)->first()->kode_bank ?? null);
                                } else {
                                    $set('kode_bank', null);
                                }
                            }),
                        Hidden::make('kode_bank'),
                        TextInput::make('no_rek')->numeric()->label('Nomor Rekening Bank')->required(),
                        TextInput::make('nama_pemilik_rekening')->label('Nama Pemilik Rekening')->extraInputAttributes(['onChange' => 'this.value = this.value.toUpperCase()'])->dehydrateStateUsing(fn($state) => strtoupper($state))->required(),
                    ]),
                Section::make('InHealth')
                    ->schema([
                        Select::make('produk_yg_dipilih')->options(Produk::all()->pluck('nama', 'kode'))->label('Produk Inhealth')->required(),
                        Select::make('kelas_rawat')->options(KelasRawat::all()->pluck('nama', 'kode'))->label('Kelas Rawat Inap Inhealth'),
                        Select::make('kode_dokter')
                            ->searchable()
                            ->options(ProviderInhealth::all()->pluck('address_virt', 'kode_provider'))
                            ->afterStateUpdated(function (Closure $set, $state) {
                                if ($state) {
                                    $set('nama_dokter', ProviderInhealth::where('kode_provider', $state)->get('nama_provider')[0]->nama_provider);
                                } else {
                                    $set('nama_dokter', null);
                                }
                            })->reactive()
                            ->label('Tentukan Fasilitas Kesehatan Inhealth')
                            ->helperText('Ketik untuk mencari, kemudian pilih.')
                            ->required(),
                        TextInput::make('nama_dokter')->disabled()->extraInputAttributes(['onChange' => 'this.value = this.value.toUpperCase()'])->dehydrateStateUsing(fn($state) => strtoupper($state))->label('Nama Fakes Dipilih'),
                    ]),
                Section::make('BPJS')
                    ->schema([
                        TextInput::make('nomor_kartu')->numeric()->label('Nomor Kartu BPJS')->required(),
                        Select::make('kelas_rawat_bpjs')->options([
                            "1" => "Kelas 1",
                            "2" => "Kelas 2",
                            "3" => "Kelas 3"
                        ])->required(),
                        Hidden::make('tgl_efektif_bpjs'),
                        Hidden::make('tmt')->default(date('01/m/Y', strtotime('+1 month'))),
                        Select::make('kode_fakes')
                            ->searchable()
                            ->options(ProviderBPJS::all()->pluck('address_virt','kode_ppk_bpjs'))
                            ->afterStateUpdated(function (Closure $set, $state) {
                                if ($state) {
                                    $set('nama_fakes', ProviderBPJS::where('kode_ppk_bpjs', $state)->get('nama_ppk_bpjs')[0]->nama_ppk_bpjs);
                                } else {
                                    $set('nama_fakes', null);
                                }
                            })
                            ->reactive()
                            ->label('Fasilitas Kesehatan BPJS')
                            ->helperText('Ketik untuk mencari, kemudian pilih.')
                            ->required(),
                        TextInput::make('nama_fakes')->disabled()->extraInputAttributes(['onChange' => 'this.value = this.value.toUpperCase()'])->dehydrateStateUsing(fn($state) => strtoupper($state))->label('Nama Fasilitas Kesehatan BPJS'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')->getStateUsing(
                    static function (stdClass $rowLoop, HasTable $livewire): string {
                        return (string) (
                            $rowLoop->iteration +
                            ($livewire->tableRecordsPerPage * (
                                $livewire->page - 1
                            ))
                        );
                    }
                )->label("NO URUT *"),
                TextColumn::make('kelas_rawat')->sortable()
                    ->label("KELAS RAWAT"),
                TextColumn::make('produk_yg_dipilih')->sortable()
                    ->label('PRODUK YG DIPILIH'),
                TextColumn::make('no_peg')
                    ->copyable()
                    ->copyMessage("NIP disalin 👍")
                    ->searchable()
                    ->sortable()
                    ->label('NO PEG *'),
                TextColumn::make('sub_group')
                    ->label('SUB GOUP*'),
                //TextColumn::make('nama_subgroup'),
                TextColumn::make('nama')->searchable()->sortable()
                    ->label('NAMA *'),
                TextColumn::make('pisa')
                    ->sortable()
                    ->label('PISA *'),
                TextColumn::make('tempat_lhr')
                    ->sortable()
                    ->label('TEMPAT LHR'),
                TextColumn::make('tgl_lhr')
                    ->formatStateUsing(fn ($state) => date('d/m/Y', strtotime($state)))
                    ->label('TGL LHR *'),
                TextColumn::make('jns_kel')
                    ->sortable()
                    ->label('JNS KEL *'),
                TextColumn::make('status_kawin')
                    ->sortable()
                    ->label('STATUS KAWIN *'),
                TextColumn::make('alamat')
                    ->searchable()
                    ->sortable()
                    ->label('ALAMAT JALAN'),
                TextColumn::make('kode_kecamatan')
                    ->sortable()
                    ->label('KODE KECAMATAN *'),
                TextColumn::make('kode_dokter')
                    ->sortable()
                    ->label('KODE DOKTER'),
                TextColumn::make('nama_dokter')
                    ->searchable()
                    ->sortable()
                    ->label('NAMA DOKTER'),
                TextColumn::make('nomor_kartu')
                    ->label('NOMOR KARTU'),
                TextColumn::make('kode_fakes')
                    ->sortable()
                    ->label('KODE FAKES'),
                /* TextColumn::make('nama_fakes')
                    ->searchable()
                    ->sortable()
                    ->label('NAMA RAWAT'), */
                TextColumn::make('kelas_rawat_bpjs')
                    ->sortable()
                    ->label('KELAS RAWAT'),
                TextColumn::make('tgl_efektif_bpjs')
                    ->sortable()
                    ->label('TGL EFEKTIF'),
                TextColumn::make('nomor_induk_kependudukan')
                    ->sortable()
                    ->label('NIK *'),
                TextColumn::make('tmt')->formatStateUsing(function ($record, $state) {
                    if (isset($state)) {
                        return $state;
                    } else {
                        return date('01/m/Y', strtotime('+1 month', strtotime($record->created_at)));
                    }
                })
                    ->label('TMT *'),
                TextColumn::make('jabatan')
                    ->label('JABATAN *'),
                TextColumn::make('gaji')
                    ->label('GAJI'),
                TextColumn::make('nama_bank')
                    ->sortable()
                    ->label('NAMA BANK'),
                TextColumn::make('no_rek')
                    ->label('NO REK *'),
                TextColumn::make('nama_pemilik_rekening')
                    ->sortable()
                    ->label('NAMA PEMILIK REK'),
                TextColumn::make('kode_divisi_eksternal')
                    ->label('KODE DIVISI EKSTERNAL'),
                TextColumn::make('cost_center')
                    ->label('COST CENTER'),
                TextColumn::make('email')->sortable()
                    ->label('EMAIL *'),
                TextColumn::make('benefit')
                    ->label('BENEFIT'),
                TextColumn::make('kode_bank')
                    ->label('KODE BANK *'),
                TextColumn::make('direktorat')
                    ->label('DIREKTORAT'),
                TextColumn::make('nama_cabang')
                    ->label('NAMA CABANG'),
                TextColumn::make('no_telepon')
                    ->label('NO TELP'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
