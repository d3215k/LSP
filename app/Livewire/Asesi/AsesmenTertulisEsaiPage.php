<?php

namespace App\Livewire\Asesi;

use App\Models\Asesmen;
use Livewire\Attributes\Title;
use Livewire\Component;

class AsesmenTertulisEsaiPage extends Component
{
    public Asesmen $asesmen;

    public function mount()
    {
        abort_unless(
            auth()->user()->isAsesi && $this->asesmen->asesi_id === auth()->user()->asesi_id
        , 403);

        $this->asesmen->load('tertulisPilihanGanda:status,asesmen_id');
    }

    #[Title('FR.IA.06 Asesmen Tertulis Esai')]
    public function render()
    {
        return <<<'HTML'
        <div>
            @if (isset($asesmen->tertulisEsai) && $asesmen->tertulisEsai?->status === \App\Enums\AsesmenTertulisStatus::MULAI)
                <livewire:asesi.cbt-esai-component :asesmenId="$asesmen->id" />
            @else
                <livewire:asesi.cbt-onboarding-tertulis-esai-component :asesmenId="$asesmen->id" />
            @endif
        </div>
        HTML;
    }
}
