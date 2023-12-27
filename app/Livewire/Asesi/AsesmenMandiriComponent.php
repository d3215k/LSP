<?php

namespace App\Livewire\Asesi;

use App\Enums\AsesmenStatus;
use App\Models\Asesmen;
use App\Models\Asesmen\JawabanMandiri;
use App\Models\Asesmen\Mandiri;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class AsesmenMandiriComponent extends Component
{
    public Asesmen $asesmen;

    public $data;

    #[On('dokumenBuktiMandiriMandiriSaved')]
    public function refresh()
    {
        //
    }

    public function mount() {
        $this->asesmen->load(['skema', 'skema.unit', 'skema.unit.elemen', 'skema.unit.elemen.kuk', 'buktiMandiri', 'mandiri']);

        $jawaban = JawabanMandiri::query()
            ->where('asesmen_mandiri_id', $this->asesmen->mandiri->id)
            ->get();

        $this->data['kompeten'] = $jawaban->pluck('kompeten', 'unit_id')->toArray();
        $this->data['bukti'] = $jawaban->pluck('bukti_asesmen_mandiri_id', 'unit_id')->toArray();
    }

    public function handleSave()
    {
        try {
            DB::beginTransaction();
            $mandiri = Mandiri::updateOrCreate(
                [
                    'asesmen_id' => $this->asesmen->id,
                ],
                [
                    'tanggal_asesmen_mandiri' => today(),
                ]
            );

            $data = [];

            foreach (array_keys($this->data['kompeten'] + $this->data['bukti']) as $key) {
                $data[$key] = [
                    "kompeten" => $this->data['kompeten'][$key] ?? null,
                    "bukti" => $this->data['bukti'][$key] ?? null,
                ];
            }

            foreach ($data as $unit => $item) {
                JawabanMandiri::updateOrCreate(
                    [
                        'asesmen_mandiri_id' => $mandiri->id,
                        'unit_id' => $unit,
                    ],
                    [
                        'kompeten' => $item['kompeten'],
                        'bukti_asesmen_mandiri_id' => $item['bukti']
                    ]
                );
            }

            $this->asesmen->update([
                'status' => AsesmenStatus::ASESMEN_MANDIRI
            ]);

            DB::commit();

            Notification::make()->title('Asesmen Mandiri Tersimpan')->success()->send();

        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function render()
    {
        return view('livewire.asesi.asesmen-mandiri-component');
    }
}
