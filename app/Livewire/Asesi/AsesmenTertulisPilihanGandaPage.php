<?php

namespace App\Livewire\Asesi;

use App\Models\Asesmen;
use Livewire\Attributes\Title;
use Livewire\Component;

class AsesmenTertulisPilihanGandaPage extends Component
{
    public Asesmen $asesmen;

    public function mount()
    {
        abort_unless(auth()->user()->isAsesi, 403);
        $this->asesmen->load('tertulisPilihanGanda:status,asesmen_id');
    }

    #[Title('FR.IA.05 Asesmen Tertulis Pilihan Ganda')]
    public function render()
    {
        return <<<'HTML'
        <div>
            @if (isset($asesmen->tertulisPilihanGanda) && $asesmen->tertulisPilihanGanda?->status === \App\Enums\AsesmenTertulisStatus::MULAI)
                <livewire:asesi.cbt-pilihan-ganda-component :asesmenId="$asesmen->id" />
            @else
                <livewire:asesi.cbt-onboarding-tertulis-pilihan-ganda-component :asesmenId="$asesmen->id" />
            @endif
        </div>
        HTML;
    }
}
