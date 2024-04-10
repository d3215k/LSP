<?php

namespace App\Livewire\Asesi;

use App\Models\Asesmen;
use Livewire\Attributes\Title;
use Livewire\Component;

class UmpanBalikDanCatatanAsesmenPage extends Component
{
    public Asesmen $asesmen;

    #[Title('FR.AK.03 UMPAN BALIK DAN CATATAN ASESMEN')]
    public function render()
    {
        return <<<'HTML'
        <div>
            <livewire:asesi.umpan-balik-dan-catatan-asesmen-component :asesmen="$this->asesmen" />
        </div>
        HTML;
    }
}
