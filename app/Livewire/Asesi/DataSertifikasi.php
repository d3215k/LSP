<?php

namespace App\Livewire\Asesi;

use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

use function Pest\Laravel\options;

class DataSertifikasi extends Component implements HasForms
{

    use InteractsWithForms;

    public ?array $data = [];

    public $signature;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Skema Sertifikasi (Okupasi)')
                    ->schema([
                        Placeholder::make('judul')
                            ->content('SKEMA')
                            ->inlineLabel(),
                        Placeholder::make('nomor')
                            ->content('1345678')
                            ->inlineLabel(),
                    ])->columns(1),
                // Select::make('tujuan')
                //     ->options([
                //         'sertifikasi' => 'Sertifikasi'
                //     ])
                //     ->default('sertifikasi')
                //     ->inlineLabel()
                //     ->selectablePlaceholder(false),
            ]);
    }

    public function save(): void
    {
        dd($this->signature);
    }

    public function render()
    {
        return view('livewire.asesi.data-sertifikasi');
    }
}
