<?php

namespace App\Filament\Resources;

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
use Filament\Resources\Resource;
use App\Models\MutasiPesertaBaru;
use Illuminate\Pagination\Paginator;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Validation\Rules\Unique;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\MutasiPesertaBaruResource\Pages;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Models\Pegawai;

class MutasiPesertaBaruResource extends Resource
{
    protected static ?string $model = MutasiPesertaBaru::class;

    protected static ?int $navigationSort = 5;

    protected static ?string $modelLabel = 'Mutasi Peserta Baru';

    protected static ?string $navigationIcon = 'heroicon-o-user-add';

    protected static ?string $slug = 'mutasi-peserta-baru';

    protected static ?string $navigationLabel = 'Mutasi Peserta Baru';

    protected static ?string $navigationGroup = 'Peserta';

    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->fastPaginate($this->getTableRecordsPerPage());
    }

    protected function getTableRecordActionUsing(): ?Closure
    {
        return null;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Identitas')
                    ->schema([
                            TextInput::make('nama')->label('Nama')->required()->extraInputAttributes(['onChange' => 'this.value = this.value.toUpperCase()'])->dehydrateStateUsing(fn ($state) => strtoupper($state)),
                            TextInput::make('email')->email()->required(),
                            TextInput::make('nomor_induk_kependudukan')->label('Nomor Induk Kependudukan (NIK)')->numeric()->length(16)->required(),
                            TextInput::make('no_peg')->label('Nomor Induk Pegawai (NIP)')
                            ->rules([
                                function () {
                                    return function (string $attribute, $value, Closure $fail) {
                                        if (!(Pegawai::where('nip', $value)->first()->is_tetap ?? 0)) {
                                            if (MutasiPesertaBaru::where('no_peg',$value)->exists()) {
                                                $fail('Kuota Inhealth untuk :attribute terbatas 1 orang.');
                                            }
                                        }
                                    };
                                },
                            ]),
                            Select::make('jabatan')->options(Jabatan::all()->pluck('nama', 'kode'))->searchable()->label('Jabatan')->preload(),
                            TextInput::make('no_telepon')->label('Nomor Telepon')->numeric(),
                            Hidden::make('sub_group')->default(''),
                            Hidden::make('nama_subgroup')->default(''),
                            TextInput::make('tempat_lhr')->label('Tempat Kelahiran')->extraInputAttributes(['onChange' => 'this.value = this.value.toUpperCase()'])->dehydrateStateUsing(fn ($state) => strtoupper($state)),
                            DatePicker::make('tgl_lhr')->label('Tanggal Lahir'),
                            Select::make('jns_kel')->options(JenisKelamin::all()->pluck('nama', 'kode'))->label('Jenis Kelamin'),
                    ]),
                Section::make('Status')
                    ->schema([
                            Select::make('pisa')->options(Pisa::all()->pluck('nama', 'kode'))->label('Status di Kartu Keluarga'),
                            Select::make('status_kawin')->options(StatusKawin::all()->pluck('nama', 'kode'))->label('Status Perkawinan'),
                            TextInput::make('alamat')->label('Alamat Lengkap')->extraInputAttributes(['onChange' => 'this.value = this.value.toUpperCase()'])->dehydrateStateUsing(fn ($state) => strtoupper($state)),
                            Select::make('kode_kecamatan')->options(KodeKecamatan::all()->pluck('nama_kecamatan', 'kode_kecamatan'))->searchable()->label('Nama Kecamatan'),
                            Select::make('nama_bank')->options(KodeBank::all()->pluck('nama_bank', 'kode_bank'))->searchable()->preload()->label('Nama Bank yang Digunakan')
                                ->reactive()
                                ->afterStateUpdated(fn (Closure $set, $state) => $set('kode_bank', KodeBank::where('nama_bank', $state)->first()->kode_bank ?? null )),
                            Hidden::make('kode_bank'),
                            TextInput::make('no_rek')->numeric()->label('Nomor Rekening Bank'),
                            TextInput::make('nama_pemilik_rekening')->label('Nama Pemilik Rekening')->extraInputAttributes(['onChange' => 'this.value = this.value.toUpperCase()'])->dehydrateStateUsing(fn ($state) => strtoupper($state)),
                    ]),
                Section::make('InHealth')
                    ->schema([
                            Select::make('produk_yg_dipilih')->options(Produk::all()->pluck('nama', 'kode'))->label('Produk Inhealth'),
                            Select::make('kelas_rawat')->options(KelasRawat::all()->pluck('nama', 'kode'))->default('3')->disabled()->label('Kelas Rawat Inap Inhealth'),
                            Select::make('kode_dokter')->searchable()
                                ->options(ProviderInhealth::all()->pluck('address_virt', 'kode_provider'))
                                ->afterStateUpdated(function (Closure $set, $state) {$set('nama_dokter', ProviderInhealth::where('kode_provider', $state)->get('nama_provider')[0]->nama_provider);})->reactive()
                                ->label('Tentukan Fasilitas Kesehatan Inhealth')
                                ->helperText('Ketik untuk mencari, kemudian pilih.'),
                            TextInput::make('nama_dokter')->disabled()->extraInputAttributes(['onChange' => 'this.value = this.value.toUpperCase()'])->dehydrateStateUsing(fn ($state) => strtoupper($state))->label('Nama Fakes Dipilih'),
                    ]),
                Section::make('BPJS')
                    ->schema([
                        TextInput::make('nomor_kartu')->numeric()->label('Nomor Kartu BPJS'),
                        Select::make('kelas_rawat_bpjs')->options([
                            "1" => "Kelas 1",
                            "2" => "Kelas 2",
                            "3" => "Kelas 3"
                        ]),
                        Hidden::make('tgl_efektif_bpjs'),
                        Hidden::make('tmt')->default(date('01/m/Y', strtotime('+1 month'))),
                        Select::make('kode_fakes')->searchable()
                            ->options(ProviderBPJS::all()->pluck('address_virt', 'kode_ppk_bpjs'))
                            ->afterStateUpdated(function (Closure $set, $state) {$set('nama_fakes', ProviderBPJS::where('kode_ppk_bpjs', $state)->get('nama_ppk_bpjs')[0]->nama_ppk_bpjs);})
                            ->reactive()
                            ->label('Fasilitas Kesehatan BPJS')
                            ->helperText('Ketik untuk mencari, kemudian pilih.'),
                        TextInput::make('nama_fakes')->disabled()->extraInputAttributes(['onChange' => 'this.value = this.value.toUpperCase()'])->dehydrateStateUsing(fn ($state) => strtoupper($state))->label('Nama Fasilitas Kesehatan BPJS'),
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
                    ->sortable('KODE DOKTER'),
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
                /* TextColumn::make('created_at')
                    ->dateTime()->toggleable(isToggledHiddenByDefault: true)->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime()->toggleable(isToggledHiddenByDefault: true)->sortable(), */
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
                FilamentExportBulkAction::make('Export yang dipilih')
                    ->fileName('Mutasi_Baru')
                    ->timeFormat('d m Y')
                    ->defaultFormat('xlsx')
                    ->defaultPageOrientation('landscape'),
            ])
            ->headerActions([
                FilamentExportHeaderAction::make('Export')
                    ->fileName('Mutasi_Baru')
                    ->timeFormat('d m Y')
                    ->defaultFormat('xlsx')
                    ->defaultPageOrientation('landscape'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageMutasiPesertaBarus::route('/'),
        ];
    }
}