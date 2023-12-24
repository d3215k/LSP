<?php

namespace App\Livewire\Asesi;

use App\Models\Asesmen;
use App\Models\Skema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class DaftarAsesmenComponent extends Component implements HasForms
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
                Select::make('skema_id')
                    ->label('Skema')
                    ->options(
                        Skema::all()->pluck('nama', 'id'),
                    )
                    ->searchable()
                    ->preload()
                    ->required(),
            ])
            ->statePath('data');
    }

    public function handleSubmit()
    {
        $data = $this->form->getState();

        $data['asesi_id'] = auth()->user()->asesi->id;

        Asesmen::create($data);

        return to_route('filament.app.pages.registrasi');
    }

    public function render()
    {
        return view('livewire.asesi.daftar-asesmen-component');
    }
}
