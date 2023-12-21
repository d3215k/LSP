<?php

namespace App\Livewire\Asesi;

use App\Models\Skema;
use Livewire\Component;

class BuktiKelengkapanPemohon extends Component
{
    public $signature;

    public $data;

    public function mount(): void
    {
        $skema = Skema::first();

        $this->data['skema'] = $skema;
    }

    public function save(): void
    {
        dd($this->signature);

        $folderPath = public_path('signature/');

        $image_parts = explode(";base64,", $this->signature);

        $image_type_aux = explode("image/", $image_parts[0]);

        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);

        $file = $folderPath . uniqid() . '.'.$image_type;

        file_put_contents($file, $image_base64);
    }

    public function render()
    {
        return view('livewire.asesi.bukti-kelengkapan-pemohon');
    }
}
