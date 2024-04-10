<?php

namespace App\Livewire\Asesi;

use App\Models\Asesmen;
use Livewire\Attributes\Title;
use Livewire\Component;

class BandingAsesmenPage extends Component
{
    public Asesmen $asesmen;

    #[Title('FR.AK.04 BANDING ASESMEN')]
    public function render()
    {
        return <<<'HTML'
        <div>
            <livewire:asesi.banding-asesmen-component :asesmen="$this->asesmen" />
        </div>
        HTML;
    }
}
