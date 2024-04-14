<?php

namespace App\Livewire\Asesor\Asesmen;

use App\Enums\AsesmenStatus;
use App\Models\Asesmen;
use App\Models\Asesmen\Persetujuan;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Notifications\Notification;
use Livewire\Component;

class PersetujuanAsesmenDanKerahasiaanComponent extends Component implements HasForms, HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;

    public Asesmen $record;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->record->persetujuan?->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('bukti')
                    ->label('Bukti yang akan dikumpulkan')
                    ->schema([
                        Forms\Components\Checkbox::make('verifikasi_portofolio'),
                        Forms\Components\Checkbox::make('observasi_langsung'),
                        Forms\Components\Checkbox::make('hasil_tes_tulis')->columnSpanFull(),
                        Forms\Components\Checkbox::make('hasil_tes_lisan')->columnSpanFull(),
                        Forms\Components\Checkbox::make('hasil_wawancara')->columnSpanFull(),
                    ])->columns(2),
                Forms\Components\Fieldset::make('pelaksanaan')
                    ->label('Pelaksanaan asesmen disepakati pada')
                    ->schema([
                        Forms\Components\DateTimePicker::make('waktu')
                            ->required()
                            ->inlineLabel()
                            ->columnSpanFull(),
                        forms\Components\Select::make('tempat_uji_kompetensi_id')
                            ->label('Tempat Uji Kompetensi')
                            ->inlineLabel()
                            ->required()
                            ->options(
                                $this->record->skema->tempatUjiKompetensi->pluck('nama', 'id')?->toArray()
                            )
                            ->columnSpanFull(),
                    ]),
            ])
            ->statePath('data')
            ->model($this->record->persetujuan);
    }

    public function handleSubmit()
    {
        Persetujuan::updateOrCreate(
            [
                'asesmen_id' => $this->record->id,
            ],
            $this->form->getState()
        );

        $this->record->update(['status' => AsesmenStatus::PERSETUJUAN]);

        Notification::make()->title('Persetujuan Tersimpan!')->success()->send();
    }

    public function persetujuanInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->record)
            ->schema([
                TextEntry::make('rincianDataPemohon.nama')
                    ->label('Asesi')
                    ->inlineLabel(),
                TextEntry::make('asesor.nama')
                    ->inlineLabel(),
                TextEntry::make('asesor.nomor_registrasi')
                    ->label('No. Reg')
                    ->inlineLabel(),
                Fieldset::make('Skema Sertifikasi')
                    ->relationship('skema')
                    ->schema([
                        TextEntry::make('nama')->label('Judul')->inlineLabel()->columnSpanFull(),
                        TextEntry::make('kode')->label('Nomor')->inlineLabel()->columnSpanFull(),
                    ]),
            ]);
    }

    public function render()
    {
        return view('livewire.asesor.asesmen.persetujuan-asesmen-dan-kerahasiaan-component');
    }
}
