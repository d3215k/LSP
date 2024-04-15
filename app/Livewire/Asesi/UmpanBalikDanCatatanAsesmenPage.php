<?php

namespace App\Livewire\Asesi;

use App\Models\Asesmen;
use Livewire\Attributes\Title;
use Livewire\Component;

class UmpanBalikDanCatatanAsesmenPage extends Component
{
    public Asesmen $asesmen;

    public function mount()
    {
        abort_unless(
            auth()->user()->isAsesi && $this->asesmen->asesi_id === auth()->user()->asesi_id
        , 403);
    }

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
