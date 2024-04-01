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
            // ->whereNotIn('status', [AsesmenStatus::DITOLAK])
            ->with('skema:id,nama,cover,tertulis_esai,tertulis_pg')
            ->latest()
            ->get();
    }

    public function mount()
    {
        // $route = match ($this->asesmen->status->value) {
        //     1 => route('filament.app.pages.permohonan-sertifikasi-kompetensi'),
        //     2 => route('filament.app.pages.asesi.asesmen-mandiri'),
        //     3,4,5,6 => route('filament.app.pages.asesmen-tertulis-esai'),
        //     11 => route('filament.app.pages.umpan-balik'),
        //     12,13 => route('filament.app.pages.banding-asesmen'),
        // };

        // $this->route = $route;
    }

    public function render()
    {
        return view('livewire.asesi.asesmen-saya');
    }
}
