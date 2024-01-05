<?php

namespace App\Livewire\Asesi;

use App\Enums\AsesmenStatus;
use App\Models\Asesmen;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AsesmenSaya extends Component
{
    public $label;
    public $route;

    #[Computed]
    public function asesmen()
    {
        return Asesmen::query()
            ->where('asesi_id', auth()->user()->asesi->id)
            ->whereNotIn('status', [AsesmenStatus::DITOLAK])
            ->with('skema:id,nama')
            ->first();
    }

    public function mount()
    {
        $this->route = route('filament.app.pages.permohonan-sertifikasi-kompetensi');
    }

    public function render()
    {
        return view('livewire.asesi.asesmen-saya');
    }
}
