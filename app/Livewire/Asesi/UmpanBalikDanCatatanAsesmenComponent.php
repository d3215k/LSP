<?php

namespace App\Livewire\Asesi;

use App\Models\Asesmen;
use App\Models\Asesmen\HasilUmpanBalik;
use App\Models\Asesmen\KomponenUmpanBalik;
use App\Models\Asesmen\UmpanBalik;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

class UmpanBalikDanCatatanAsesmenComponent extends Component
{
    public Asesmen $asesmen;

    public ?array $data = [];

    public function mount()
    {
        abort_unless(
            auth()->user()->isAsesi && $this->asesmen->asesi_id === auth()->user()->asesi_id
        , 403);

        $hasil = HasilUmpanBalik::query()
            ->where('asesmen_umpan_balik_id', $this->asesmen->umpanBalik?->id)
            ->get();

        $this->data['hasil'] = $hasil->pluck('hasil', 'komponen_umpan_balik_id')->toArray();
        $this->data['catatan'] = $hasil->pluck('catatan', 'komponen_umpan_balik_id')->toArray();

    }

    #[Computed()]
    public function komponen()
    {
        return KomponenUmpanBalik::query()
            ->get();
    }

    public function handleSave()
    {
        if (count($this->data['hasil']) !== count($this->komponen)) {
            return Notification::make()->title('Whoops!')->body('Ada komponen yang belum dijawab')->danger()->send();
        }

        try {
            DB::beginTransaction();
            $umpanBalik = UmpanBalik::updateOrCreate(
                [
                    'asesmen_id' => $this->asesmen->id,
                ],
                [
                    'tanggal' => today(),
                    'catatan' => ''
                ]
            );

            $data = [];


            foreach (array_keys($this->data['hasil'] + $this->data['catatan']) as $key) {
                $data[$key] = [
                    "hasil" => $this->data['hasil'][$key] ?? null,
                    "catatan" => $this->data['catatan'][$key] ?? null,
                ];
            }


            foreach ($data as $key => $value) {
                HasilUmpanBalik::updateOrCreate(
                    [
                        'asesmen_umpan_balik_id' => $umpanBalik->id,
                        'komponen_umpan_balik_id' => $key,
                    ],
                    [
                        'hasil' => $value['hasil'],
                        'catatan' => $value['catatan'],
                    ]
                );
            }

            DB::commit();
            Notification::make()->title('Data Tersimpan')->success()->send();

        } catch (\Throwable $th) {
            report($th->getMessage());
            Notification::make()->title('Whoops! Ada yang salah')->danger()->send();
            DB::rollBack();
        }
    }

    public function render()
    {
        return view('livewire.asesi.umpan-balik-dan-catatan-asesmen-component');
    }
}
