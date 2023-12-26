<?php

namespace App\Livewire\Asesi;

use App\Models\Asesmen;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Illuminate\Support\Facades\File;
use Livewire\Attributes\On;
use Livewire\Component;

class PemohonAsesmenComponent extends Component implements HasForms, HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;

    public Asesmen $asesmen;

    public $signature;

    #[On('rincian-saved')]
    public function refresh()
    {
        //
    }

    public function asesiInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->asesmen?->rincian)
            ->schema([
                TextEntry::make('nama')->inlineLabel(),
                TextEntry::make('tanggal_registrasi')->inlineLabel(),
            ]);
    }

    public function handleSubmit()
    {
        if ($this->asesmen->ttd_asesi) {
            return;
        }

        try {
            $ttd = uploadSignature('ttd/asesmen/asesi', $this->signature, $this->asesmen->id);
            $this->asesmen->update(['ttd_asesi' => $ttd]);
            $this->dispatch('rincian-saved');

            // return to_route('filament.app.pages.beranda');
        } catch (\Throwable $th) {
            $th->getMessage();
        }

    }

    public function render()
    {
        return view('livewire.asesi.pemohon-asesmen-component');
    }
}
