<?php

namespace App\Livewire\Asesi;

use App\Models\Asesmen;
use App\Models\RincianDataPemohon;
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

class RincianDataPemohonSertifikasi extends Component implements HasForms
{
    use InteractsWithForms;

    public Asesmen $asesmen;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(
            $this->asesmen->rincian->toArray()
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
                            ->required()
                            ->default($this->asesmen->asesi->nama),
                        TextInput::make('no_identitas')
                            ->label('No KTP/NIK/Paspor')
                            ->required(),
                        Radio::make('jk')
                            ->label('Jenis Kelamin')
                            ->options([
                                'L' => "Laki-laki",
                                'P' => "Perempuan",
                            ])
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('tempat_lahir')
                            ->label('Tempat Lahir')
                            ->required(),
                        DatePicker::make('tanggal_lahir')
                            ->label('Tanggal Lahir')
                            ->required(),
                        TextInput::make('kebangsaan')
                            ->label('Kebangsaan')
                            ->required(),
                        TextInput::make('alamat_rumah')
                            ->label('Alamat')
                            ->required(),
                        TextInput::make('kode_pos')
                            ->label('Kode Pos')
                            ->required(),
                        TextInput::make('no_telepon_rumah')
                            ->label('No Telepon (Rumah)')
                            ->required(),
                        TextInput::make('no_telepon_hp')
                            ->label('No Telepon (HP aktif WhatsApp)')
                            ->required(),
                        TextInput::make('kualifikasi_pendidikan')
                            ->label('Kualifikasi Pendidikan')
                            ->required(),
                    ])
                    ->columns(2),
                Fieldset::make('B. Data Pekerjaan Sekarang')
                    ->schema([
                        TextInput::make('nama_institusi')
                            ->label('Nama Institusi / Perusahaan')
                            ->required(),
                        TextInput::make('jabatan')
                            ->label('Jabatan')
                            ->required(),
                        TextInput::make('alamat_kantor')
                            ->label('Alamat Kantor')
                            ->required(),
                        TextInput::make('kode_pos_kantor')
                            ->label('Kode Pos Kantor')
                            ->required(),
                        TextInput::make('no_telepon_kantor')
                            ->label('No Telepon Kantor')
                            ->required(),
                        TextInput::make('no_fax_kantor')
                            ->label('No Fax Kantor')
                            ->required(),
                        TextInput::make('email_kantor')
                            ->label('Email Kantor')
                            ->required(),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        RincianDataPemohon::updateOrCreate(
            [
                'asesmen_id' => $this->asesmen->id,
            ],
            $this->form->getState()
        );

        Notification::make()
            ->title('Rincian Data Pemohon Sertifikasi Tersimpan!')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.asesi.rincian-data-pemohon-sertifikasi');
    }
}
