<?php

namespace App\Livewire\Asesor\AsesmenMandiri;

use App\Enums\AsesmenStatus;
use App\Enums\RekomendasiAsesmenMandiri;
use App\Models\Asesmen;
use App\Models\Asesmen\Mandiri;
use App\Support\Signature;
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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;

class PenilaianAsesmenMandiriComponent extends Component implements HasForms, HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;

    public Mandiri $mandiri;

    public $ttd_asesor;

    public ?array $data = [];

    #[On('saved')]
    public function refresh()
    {
        //
    }

    public function mount(): void
    {
        $this->rekomendasiForm->fill($this->mandiri->toArray());
    }

    protected function getForms(): array
    {
        return [
            'rekomendasiForm',
            'ttdAsesorForm',
        ];
    }

    public function rekomendasiForm(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('catatan')
                    ->required()
                    ->inlineLabel()
                    ->columnSpanFull(),
                Radio::make('rekomendasi')
                    ->options(RekomendasiAsesmenMandiri::class)
                    ->inline()->inlineLabel()
                    ->required()
                    ->columnSpanFull(),
            ])
            ->statePath('data')
            ->columns(4);
    }

    public function ttdAsesorForm(Form $form): Form
    {
        return $form
            ->schema([
                SignaturePad::make('ttd_asesor')
                    ->label('Tanda tangan asesor')
                    ->penColor('black')
                    ->penColorOnDark('black')
                    ->columnSpan(1),
            ])
            ->columns(4);
    }

    public function asesorInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->mandiri->asesmen->asesor)
            ->schema([
                TextEntry::make('nama')->inlineLabel(),
                TextEntry::make('nomor_registrasi')->label('No. Reg')->inlineLabel(),
                // TextEntry::make('tanggal_registrasi')->label('Tanggal')->inlineLabel(),
            ]);
    }

    public function handleSubmit()
    {
        $this->validate();

        try {
            DB::beginTransaction();
            if (empty($this->mandiri->asesmen->ttd_asesor) && empty($this->ttd_asesor) ) {
                return Notification::make()->title('Whoops!')->body('Tanda tangan harus diisi')->danger()->send();
            }

            if ($this->ttd_asesor) {
                if ($this->mandiri->asesmen->ttd_asesor) {
                    return;
                }
                $ttd = Signature::upload('ttd/asesmen/asesor/', $this->ttd_asesor, $this->mandiri->asesmen->id);
                $this->mandiri->asesmen->update(['ttd_asesor' => $ttd]);
            }

            $data = $this->rekomendasiForm->getState();

            $this->mandiri->update([
                'tanggal_ditinjau' => today(),
                'rekomendasi' => $data['rekomendasi'],
                'catatan' => $data['catatan'],
            ]);

            $this->dispatch('saved');

            $this->reset('ttd_asesor');

            DB::commit();
            Notification::make()->title('Penilaian Berhasil disimpan!')->success()->send();

        } catch (\Throwable $th) {
            report($th->getMessage());
            Notification::make()->title('Whoops! Ada yang salah')->danger()->send();
            DB::rollBack();
        }

    }

    public function render()
    {
        return view('livewire.asesor.asesmen-mandiri.penilaian-asesmen-mandiri-component');
    }
}
