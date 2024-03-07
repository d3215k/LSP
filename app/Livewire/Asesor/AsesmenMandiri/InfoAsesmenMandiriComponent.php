<?php

namespace App\Livewire\Asesor\AsesmenMandiri;

use App\Models\Asesmen\BuktiMandiri;
use App\Models\Asesmen\JawabanMandiri;
use App\Models\Asesmen\Mandiri;
use Livewire\Component;

class InfoAsesmenMandiriComponent extends Component
{
    public Mandiri $mandiri;

    public $data;

    public function mount()
    {
        $this->mandiri->load('asesmen', 'asesmen.skema', 'asesmen.skema.unit', 'asesmen.skema.unit.elemen', 'asesmen.skema.unit.elemen.kriteriaUnjukKerja');

        $jawaban = JawabanMandiri::query()
            ->where('asesmen_mandiri_id', $this->mandiri->id)
            ->get();

        $this->data['kompeten'] = $jawaban->pluck('kompeten', 'elemen_id')->toArray();

        $ids = $jawaban->pluck('bukti_asesmen_mandiri_id')
            // ->filter(fn ($value) => $value !== null) TODO : filter
            ;

        $bukti = BuktiMandiri::query()
            ->whereIn('id', $ids)
            ->get();

        foreach ($jawaban as $item) {
            $this->data['bukti'][$item->elemen_id] = $bukti->where('id', $item->bukti_asesmen_mandiri_id)->first();
        }

    }

    public function render()
    {
        return view('livewire.asesor.asesmen-mandiri.info-asesmen-mandiri-component');
    }
}
