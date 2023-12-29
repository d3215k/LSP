<?php

namespace App\Livewire\Asesor\AsesmenMandiri;

use App\Models\Asesmen;
use App\Models\Asesmen\Mandiri;
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

    public Mandiri $mandiri;

    public function asesiInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->mandiri->asesmen->rincianDataPemohon)
            ->schema([
                TextEntry::make('nama')->inlineLabel(),
                TextEntry::make('tanggal_registrasi')->label('Tanggal')->inlineLabel(),
            ]);
    }

    public function render()
    {
        return view('livewire.asesor.asesmen-mandiri.pemohon-asesmen-component');
    }
}
