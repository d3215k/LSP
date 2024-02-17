<?php

namespace App\Livewire\Asesi\PermohonanSertifikasiKompetensi;

use App\Models\Asesmen;
use App\Models\Skema\Persyaratan;
use App\Support\Signature;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;

class PemohonAsesmenComponent extends Component implements HasForms, HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;

    public ?array $data = [];

    public Asesmen $asesmen;

    public $signature;

    #[On('rincian-saved')]
    public function refresh()
    {
        //
    }

    public function mount(): void
    {
        $this->form->fill([
            'ttd_asesi' => $this->asesmen->ttd_asesi,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                SignaturePad::make('ttd_asesi')
                    ->label(__('Tanda tangan asesi'))
                    ->maxWidth(100)
                    ->dotSize(2.0)
                    ->lineMinWidth(0.5)
                    ->lineMaxWidth(2.5)
                    ->throttle(16)
                    ->minDistance(5)
                    ->velocityFilterWeight(0.7)
                    ->columnSpan(1),
            ])
            ->columns(4)
            ->statePath('data');
    }

    public function asesiInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->asesmen?->rincianDataPemohon)
            ->schema([
                TextEntry::make('nama')->columnSpan(1),
                TextEntry::make('tanggal_registrasi')->label('Tanggal')->columnSpan(1),
            ])->columns(2);
    }

    public function handleSubmit()
    {
        $data = $this->form->getState();

        if (!$this->asesmen->rincianDataPemohon()->exists()) {
            return Notification::make()->title('Whoops!')
                ->body('Bagian 1 : Rincian Data Pemohon Sertifikasi belum diisi atau disimpan')->danger()->send();
        }

        if (empty($this->asesmen->tujuan)) {
            return Notification::make()->title('Whoops!')
                ->body('Bagian 2 : Data Sertifikasi belum diisi atau disimpan')->danger()->send();
        }

        // if ($this->asesmen->buktiPersyaratan()->count() !== Persyaratan::query()->where('skema_id', $this->asesmen->skema_id)->count()) {
        //     return Notification::make()->title('Whoops!')
        //         ->body('Bagian 3 : Bukti Kelengkapan Pemohon belum lengkap')->danger()->send();
        // }

        if (empty($data['ttd_asesi'])) {
            return Notification::make()->title('Whoops!')
                ->body('Tanda tangan belum diisi')->danger()->send();
        }

        if ($this->asesmen->ttd_asesi) {
            return;
        }

        try {
            $ttd = Signature::upload('ttd/asesmen/asesi/', $data['ttd_asesi'], $this->asesmen->id);
            $this->asesmen->update(['ttd_asesi' => $ttd]);
            $this->dispatch('rincian-saved');

            // return to_route('filament.app.pages.beranda');
            Notification::make()->title('Berhasil!')->body('Permohonan Sertifikasi Kompetensi Anda Sudah Terkirim')->success()->send();
        } catch (\Throwable $th) {
            Notification::make()->title('Whoops!')->body('Ada yang salah')->danger()->send();
            report($th->getMessage());
        }

    }

    public function render()
    {
        return view('livewire.asesi.registrasi.pemohon-asesmen-component');
    }
}
