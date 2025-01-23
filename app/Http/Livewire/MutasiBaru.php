<?php

namespace App\Http\Livewire;

use Closure;
use App\Models\Pisa;
use App\Models\Produk;
use App\Models\Jabatan;
use App\Models\Pegawai;
use Livewire\Component;
use App\Models\KodeBank;
use App\Models\KelasRawat;
use App\Models\StatusKawin;
use App\Models\JenisKelamin;
use App\Models\ProviderBPJS;
use App\Models\KodeKecamatan;
use App\Models\ProviderInhealth;
use App\Models\MutasiPesertaBaru;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;


class MutasiBaru extends Component implements HasForms
{
    use InteractsWithForms;

    public $showTY = false;

    public function mount(): void
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            Section::make('Identitas')
                ->schema([
                    TextInput::make('nama')->label('Nama')->required()->extraInputAttributes(['onChange' => 'this.value = this.value.toUpperCase()'])->dehydrateStateUsing(fn($state) => strtoupper($state)),
                    TextInput::make('email')->email()->required(),
                    TextInput::make('nomor_induk_kependudukan')->label('Nomor Induk Kependudukan (NIK)')->numeric()->length(16)->required(),
                    TextInput::make('no_peg')->label('Nomor Induk Pegawai (NIP)')
                        ->required()
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
                    TextInput::make('no_telepon')->label('Nomor Telepon')->numeric()->required(),
                    Hidden::make('sub_group')->default(''),
                    Hidden::make('nama_subgroup')->default(''),
                    TextInput::make('tempat_lhr')->label('Tempat Kelahiran')->extraInputAttributes(['onChange' => 'this.value = this.value.toUpperCase()'])->dehydrateStateUsing(fn($state) => strtoupper($state))->required(),
                    DatePicker::make('tgl_lhr')->label('Tanggal Lahir')->required(),
                    Select::make('jns_kel')->options(JenisKelamin::all()->pluck('nama', 'kode'))->label('Jenis Kelamin'),
                ]),
            Section::make('Status')
                ->schema([
                    Select::make('pisa')->options(Pisa::all()->pluck('nama', 'kode'))->label('Status di Kartu Keluarga')->required(),
                    Select::make('status_kawin')->options(StatusKawin::all()->pluck('nama', 'kode'))->label('Status Perkawinan')->required(),
                    TextInput::make('alamat')->label('Alamat Lengkap')->extraInputAttributes(['onChange' => 'this.value = this.value.toUpperCase()'])->dehydrateStateUsing(fn($state) => strtoupper($state)),
                    Select::make('kode_kecamatan')->options(KodeKecamatan::all()->pluck('nama_kecamatan', 'kode_kecamatan'))->searchable()->label('Nama Kecamatan'),
                    Select::make('nama_bank')->options(KodeBank::all()->pluck('nama_bank', 'kode_bank'))->searchable()->preload()->label('Nama Bank yang Digunakan')
                        ->reactive()
                        ->afterStateUpdated(fn (Closure $set, $state) => $set('kode_bank', KodeBank::where('nama_bank', $state)->first()->kode_bank ?? null )),
                    Hidden::make('kode_bank'),
                    TextInput::make('no_rek')->numeric()->label('Nomor Rekening Bank'),
                    TextInput::make('nama_pemilik_rekening')->label('Nama Pemilik Rekening')->extraInputAttributes(['onChange' => 'this.value = this.value.toUpperCase()'])->dehydrateStateUsing(fn($state) => strtoupper($state)),
                ]),
            Section::make('InHealth')
                ->schema([
                    Select::make('produk_yg_dipilih')->options(Produk::all()->pluck('nama', 'kode'))->label('Produk Inhealth'),
                    Select::make('kelas_rawat')->options(KelasRawat::all()->pluck('nama', 'kode'))->default('3')->disabled()->label('Kelas Rawat Inap Inhealth'),
                    Select::make('kode_dokter')->searchable()->getSearchResultsUsing(fn(string $search) => ProviderInhealth::where('address_virt', 'like', "%{$search}%")->limit(100)->pluck('address_virt', 'kode_provider'))->getOptionLabelUsing(fn($value): ?string => ProviderInhealth::where('kode_provider', $value)->get('nama_provider')->nama_provider)->afterStateUpdated(function (Closure $set, $state) {
                        $set('nama_dokter', ProviderInhealth::where('kode_provider', $state)->get('nama_provider')[0]->nama_provider);
                    })->reactive()->label('Tentukan Fasilitas Kesehatan Inhealth')->helperText('Ketik untuk mencari, kemudian pilih.'),
                    TextInput::make('nama_dokter')->disabled()->extraInputAttributes(['onChange' => 'this.value = this.value.toUpperCase()'])->dehydrateStateUsing(fn($state) => strtoupper($state))->label('Nama Fakes Dipilih'),
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
                    Select::make('kode_fakes')
                        ->searchable()
                        ->getSearchResultsUsing(fn(string $search) => ProviderBPJS::where('address_virt', 'like', "%{$search}%")->limit(100)->pluck('address_virt', 'kode_ppk_bpjs'))
                        ->getOptionLabelUsing(fn($value): ?string => ProviderBPJS::where('kode_ppk_bpjs', $value)->get('nama_ppk_bpjs')->nama_ppk_bpjs)
                        ->afterStateUpdated(function (Closure $set, $state) {
                            $set('nama_fakes', ProviderBPJS::where('kode_ppk_bpjs', $state)->get('nama_ppk_bpjs')[0]->nama_ppk_bpjs);
                        })
                        ->reactive()
                        ->label('Fasilitas Kesehatan BPJS')
                        ->helperText('Ketik untuk mencari, kemudian pilih.'),
                    TextInput::make('nama_fakes')->disabled()->extraInputAttributes(['onChange' => 'this.value = this.value.toUpperCase()'])->dehydrateStateUsing(fn($state) => strtoupper($state))->label('Nama Fasilitas Kesehatan BPJS'),
                ]),
        ];
    }

    public function getFormModel(): string
    {
        return MutasiPesertaBaru::class;
    }

    public function submit(): void
    {
        MutasiPesertaBaru::create($this->form->getState());
        $this->dispatchBrowserEvent('show-t-y');
        $this->showTY = true;
    }

    public function showTY()
    {
        $this->showTY = false;
    }

    public function render()
    {
        return view('livewire.mutasi-baru');
    }

    public function getListeners()
    {
        return [
            'show-t-y' => 'showTY'
        ];
    }
}
