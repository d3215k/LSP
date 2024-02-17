<?php

namespace App\Livewire\Asesi;

use App\Enums\AsesmenStatus;
use App\Models\Asesmen;
use App\Models\Asesmen\JawabanMandiri;
use App\Models\Asesmen\Mandiri;
use App\Models\Skema\Elemen;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class AsesmenMandiriComponent extends Component
{
    public Asesmen $asesmen;

    public $data;

    #[On('dokumenBuktiMandiriSaved')]
    public function refresh()
    {
        //
    }

    public function mount() {
        $this->asesmen->load(['skema', 'skema.unit', 'skema.unit.elemen', 'skema.unit.elemen.kriteriaUnjukKerja', 'buktiMandiri', 'mandiri']);

        $jawaban = JawabanMandiri::query()
            ->where('asesmen_mandiri_id', $this->asesmen->mandiri?->id)
            ->get();

        $this->data['kompeten'] = $jawaban->pluck('kompeten', 'elemen_id')->toArray();
        $this->data['bukti'] = $jawaban->pluck('bukti_asesmen_mandiri_id', 'elemen_id')->toArray();
    }

    public function handleSave()
    {
        $elemen = Elemen::whereIn('unit_id', $this->asesmen->skema->unit->pluck('id'))->count();

        if (count($this->data['kompeten']) !== $elemen) {
            return Notification::make()->title('Whoops!')->body('Ada Elemen yang belum dijawab')->danger()->send();
        }

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

            foreach ($data as $elemen => $item) {
                JawabanMandiri::updateOrCreate(
                    [
                        'asesmen_mandiri_id' => $mandiri->id,
                        'elemen_id' => $elemen,
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
            Notification::make()->title('Whoops!')->body('Ada yang salah')->danger()->send();
            report($th->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.asesi.asesmen-mandiri-component');
    }
}
