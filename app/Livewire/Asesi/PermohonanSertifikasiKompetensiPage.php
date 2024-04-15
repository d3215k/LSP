<?php

namespace App\Livewire\Asesi;

use App\Models\Asesmen;
use Livewire\Attributes\Title;
use Livewire\Component;

class PermohonanSertifikasiKompetensiPage extends Component
{
    public Asesmen $asesmen;

    public function mount()
    {
        abort_unless(
            auth()->user()->isAsesi && $this->asesmen->asesi_id === auth()->user()->asesi_id
        , 403);
    }

    #[Title('FR.APL.01 Permohonan Sertifikasi Kompetensi')]
    public function render()
    {
        return <<<'HTML'
        <div class="space-y-6">
            <livewire:asesi.permohonan-sertifikasi-kompetensi.rincian-data-pemohon-sertifikasi-component :asesmen="$asesmen" />
            <livewire:asesi.permohonan-sertifikasi-kompetensi.data-sertifikasi-component :asesmen="$asesmen" />
            <livewire:asesi.permohonan-sertifikasi-kompetensi.bukti-kelengkapan-pemohon-component :asesmen="$asesmen" />
            <livewire:asesi.permohonan-sertifikasi-kompetensi.pemohon-asesmen-component :asesmen="$asesmen" />
        </div>
        HTML;
    }
}
