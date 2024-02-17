<?php

namespace App\Livewire\Asesi\PermohonanSertifikasiKompetensi;

use App\Enums\JenisKelamin;
use App\Models\Asesmen;
use App\Models\Asesmen\RincianDataPemohon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Livewire\Component;

class RincianDataPemohonSertifikasiComponent extends Component implements HasForms
{
    use InteractsWithForms;

    public Asesmen $asesmen;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(
            $this->asesmen->rincianDataPemohon?->toArray()
        );
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('A. Data Pribadi')
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama Lengkap')
                            ->default($this->asesmen->asesi->nama)
                            ->required(),
                        TextInput::make('no_identitas')
                            ->label('No KTP/NIK/Paspor')
                            ->default($this->asesmen->asesi->nik)
                            ->required(),
                        Radio::make('jk')
                            ->label('Jenis Kelamin')
                            ->default($this->asesmen->asesi->jk)
                            ->options(JenisKelamin::class)
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('tempat_lahir')
                            ->default($this->asesmen->asesi->tempat_lahir)
                            ->label('Tempat Lahir')
                            ->required(),
                        DatePicker::make('tanggal_lahir')
                            ->default($this->asesmen->asesi->tanggal_lahir)
                            ->label('Tanggal Lahir')
                            ->required(),
                        TextInput::make('kebangsaan')
                            ->default($this->asesmen->asesi->kewarganegaraan)
                            ->label('Kebangsaan')
                            ->required(),
                        TextInput::make('alamat_rumah')
                            ->default($this->asesmen->asesi->alamat_rumah)
                            ->label('Alamat')
                            ->required(),
                        TextInput::make('kode_pos')
                            ->default($this->asesmen->asesi->kode_pos)
                            ->label('Kode Pos')
                            ->required(),
                        TextInput::make('no_telepon_rumah')
                            ->default($this->asesmen->asesi->no_telepon_rumah)
                            ->label('No Telepon (Rumah)')
                            ->required(),
                        TextInput::make('no_telepon_hp')
                            ->default($this->asesmen->asesi->no_telepon_hp)
                            ->label('No Telepon (HP aktif WhatsApp)')
                            ->required(),
                        TextInput::make('kualifikasi_pendidikan')
                            ->label('Kualifikasi Pendidikan')
                            ->default('SMK')
                            ->required(),
                    ])
                    ->columns(2),
                Fieldset::make('B. Data Pekerjaan Sekarang')
                    ->schema([
                        TextInput::make('nama_institusi')
                            ->label('Nama Institusi / Perusahaan')
                            ->default($this->asesmen->asesi->sekolah->nama)
                            ->required(),
                        TextInput::make('jabatan')
                            ->default('Siswa')
                            ->label('Jabatan')
                            ->required(),
                        TextInput::make('alamat_kantor')
                            ->default($this->asesmen->asesi->sekolah->alamat)
                            ->label('Alamat Kantor')
                            ->required(),
                        TextInput::make('kode_pos_kantor')
                            ->default($this->asesmen->asesi->sekolah->kode_pos)
                            ->label('Kode Pos Kantor')
                            ->required(),
                        TextInput::make('no_telepon_kantor')
                            ->default($this->asesmen->asesi->sekolah->no_telepon)
                            ->label('No Telepon Kantor')
                            ->required(),
                        TextInput::make('no_fax_kantor')
                            ->default($this->asesmen->asesi->sekolah->no_fax)
                            ->label('No Fax Kantor')
                            ->required(),
                        TextInput::make('email_kantor')
                            ->default($this->asesmen->asesi->sekolah->email)
                            ->label('Email Kantor')
                            ->required(),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $this->validate();

        $data = $this->form->getState();

        $data['tanggal_registrasi'] = today();

        RincianDataPemohon::updateOrCreate(
            [
                'asesmen_id' => $this->asesmen->id,
            ],
            $data,
        );

        $this->dispatch('rincian-saved');

        Notification::make()
            ->title('Berhasil disimpan!')
            ->body('Bagian 1 : Rincian Data Pemohon Sertifikasi')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.asesi.registrasi.rincian-data-pemohon-sertifikasi-component');
    }
}
