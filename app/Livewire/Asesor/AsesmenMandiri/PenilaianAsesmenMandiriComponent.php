<?php

namespace App\Livewire\Asesor\AsesmenMandiri;

use App\Enums\AsesmenStatus;
use App\Enums\RekomendasiAsesmenMandiri;
use App\Models\Asesmen;
use App\Models\Asesmen\Mandiri;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\File;
use Livewire\Attributes\On;
use Livewire\Component;

class PenilaianAsesmenMandiriComponent extends Component implements HasForms, HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;

    public Mandiri $mandiri;

    public $signature;

    public ?array $data = [];

    #[On('saved')]
    public function refresh()
    {
        //
    }

    public function mount(): void
    {
        $this->form->fill($this->mandiri->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('catatan')
                    ->required()
                    ->inlineLabel(),
                Radio::make('rekomendasi')
                    ->options(RekomendasiAsesmenMandiri::class)
                    ->inlineLabel()
                    ->inline()
                    ->required(),
            ])
            ->statePath('data');
    }

    public function asesorInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->mandiri->asesmen->asesor)
            ->schema([
                TextEntry::make('nama')->inlineLabel(),
                // TextEntry::make('tanggal_registrasi')->label('Tanggal')->inlineLabel(),
            ]);
    }

    public function handleSubmit()
    {

        try {
            if ($this->signature) {
                if ($this->mandiri->asesmen->ttd_asesor) {
                    return;
                }

                $ttd = uploadSignature('ttd/asesmen/asesor', $this->signature, $this->mandiri->asesmen->id);
                $this->mandiri->asesmen->update(['ttd_asesor' => $ttd]);
            }

            $data = $this->form->getState();

            $this->mandiri->update([
                'tanggal_ditinjau' => today(),
                'rekomendasi' => $data['rekomendasi'],
                'catatan' => $data['catatan'],
            ]);

            $this->dispatch('saved');

            Notification::make()
                ->title('Penilaian Berhasil disimpan!')
                ->success()->send();

            // return to_route('filament.app.pages.nilai-asesmen-mandiri');
        } catch (\Throwable $th) {
            $th->getMessage();
        }

    }

    public function render()
    {
        return view('livewire.asesor.asesmen-mandiri.penilaian-asesmen-mandiri-component');
    }
}
