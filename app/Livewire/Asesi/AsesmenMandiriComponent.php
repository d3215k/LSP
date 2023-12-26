<?php

namespace App\Livewire\Asesi;

use App\Models\Asesmen;
use Livewire\Component;

class AsesmenMandiriComponent extends Component
{
    public Asesmen $asesmen;

    public function mount() {
        $this->asesmen->load(['skema', 'skema.unit', 'skema.unit.elemen', 'skema.unit.elemen.kuk', 'buktiMandiri']);

        // dd($this->asesmen->skema->id);
    }

    public function render()
    {
        return view('livewire.asesi.asesmen-mandiri-component');
    }
}
