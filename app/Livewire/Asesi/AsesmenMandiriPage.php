<?php

namespace App\Livewire\Asesi;

use App\Models\Asesmen;
use Livewire\Attributes\Title;
use Livewire\Component;

class AsesmenMandiriPage extends Component
{
    public Asesmen $asesmen;

    public function mount()
    {
        abort_unless(
            auth()->user()->isAsesi && $this->asesmen->asesi_id === auth()->user()->asesi_id
        , 403);
    }

    #[Title('FR.APL.02 ASESMEN MANDIRI')]
    public function render()
    {
        return <<<'HTML'
        <div class="space-y-6">
            <livewire:asesi.dokumen-bukti-mandiri-component :asesmen="$asesmen" />
            <livewire:asesi.asesmen-mandiri-component :asesmen="$asesmen" />
        </div>
        HTML;
    }
}
