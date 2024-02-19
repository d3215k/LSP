<?php

namespace App\Livewire\Asesi;

use App\Enums\AsesmenStatus;
use App\Models\Asesmen;
use App\Models\Asesor;
use App\Models\Periode;
use App\Models\Skema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class PendaftaranAsesmenComponent extends Component implements HasForms
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
                        function () {
                            $registerd = Asesmen::query()
                                ->where('asesi_id', auth()->user()->asesi->id)
                                ->whereNotIn('status', [AsesmenStatus::DITOLAK])
                                ->pluck('skema_id');

                            return Skema::whereHas('periode', function ($query) use ($registerd) {
                                $query
                                    ->whereNotIn('id', $registerd)
                                    ->where('buka', '<=', today())
                                    ->where('tutup', '>=', today());
                            })->pluck('nama', 'id');
                        }
                    )
                    ->searchable()->preload()->required()->reactive(),
                Select::make('periode_id')
                    ->label('Periode')
                    ->options(fn (Get $get): Collection => Periode::query()
                        ->where('skema_id', $get('skema_id'))
                        ->where('buka', '<=', today())
                        ->where('tutup', '>=', today())
                        ->pluck('nama', 'id')
                    )
                    ->required()
                    ->hidden(fn (Get $get): bool => ! $get('skema_id')),
                Select::make('asesor_id')
                    ->label('Asesor')
                    ->options(fn (Get $get): Collection => Asesor::query()
                        ->whereHas('skema',
                            fn ($query) => $query->where('skema_id', $get('skema_id'))
                        )->pluck('nama', 'id')
                    )
                    ->required()
                    ->hidden(fn (Get $get): bool => ! $get('skema_id')),
            ])
            ->statePath('data');
    }

    public function handleSubmit()
    {
        $this->validate();

        $data = $this->form->getState();

        $data['asesi_id'] = auth()->user()->asesi->id;

        $data['status'] = AsesmenStatus::REGISTRASI;

        $asesmen = Asesmen::updateOrCreate($data);

        return to_route('filament.app.pages.asesi.{record}.permohonan-sertifikasi-kompetensi', $asesmen->id);
    }

    public function render()
    {
        return view('livewire.asesi.pendaftaran-asesmen-component');
    }
}
