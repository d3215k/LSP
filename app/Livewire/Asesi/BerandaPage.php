<?php

namespace App\Livewire\Asesi;

use Livewire\Attributes\Title;
use Livewire\Component;

class BerandaPage extends Component
{
    public $showAsesmenSaya = false;

    public function mount(): void
    {
        abort_unless(auth()->user()->isAsesi, 403);

        $this->showAsesmenSaya = auth()->user()->asesi->asesmen()->exists();

    }

    #[Title('Beranda')]
    public function render()
    {
        return <<<'HTML'
        <div class="space-y-6">
            @if ($showAsesmenSaya)
                <livewire:asesi.asesmen-saya />
            @endif

            <livewire:asesi.pendaftaran-asesmen-component />
        </div>
        HTML;
    }
}
