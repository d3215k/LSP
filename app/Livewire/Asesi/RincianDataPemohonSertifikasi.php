<?php

namespace App\Livewire\Asesi;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class RincianDataPemohonSertifikasi extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('A. Data Pribadi')
                    ->schema([
                        TextInput::make('nama')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('nisn')
                            ->required(),
                        TextInput::make('nik')
                            ->required(),
                        TextInput::make('tempat_lahir')
                            ->required(),
                        DatePicker::make('tanggal_lahir')
                            ->required(),
                        Radio::make('jk')
                            ->label('Jenis Kelamin')
                            ->options([
                                'L' => "Laki-laki",
                                'P' => "Perempuan",
                            ])
                            ->inline()
                            ->required(),
                    ])
                    ->columns(2),
                Fieldset::make('B. Data Pekerjaan Sekarang')
                    ->schema([
                        TextInput::make('Nama Institusi / Perusahaan')
                            ->default('SMKN 1 Cibadak')
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        dd($this->form->getState());
    }

    public function render()
    {
        return view('livewire.asesi.rincian-data-pemohon-sertifikasi');
    }
}
