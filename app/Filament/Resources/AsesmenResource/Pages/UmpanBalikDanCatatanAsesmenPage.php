<?php

namespace App\Filament\Resources\AsesmenResource\Pages;

use App\Filament\Resources\AsesmenResource;
use App\Models\Asesmen\HasilUmpanBalik;
use App\Models\Asesmen\KomponenUmpanBalik;
use App\Models\Asesmen\UmpanBalik;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;

class UmpanBalikDanCatatanAsesmenPage extends Page implements HasForms
{
    use InteractsWithRecord;
    use InteractsWithForms;

    protected static string $resource = AsesmenResource::class;

    protected static string $view = 'filament.resources.asesmen-resource.pages.umpan-balik-dan-catatan-asesmen-page';

    protected static ?string $title = 'FR.AK.03';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public ?array $data = [];

    public function getHeading(): string
    {
        return $this->getRecord()->asesi->nama;
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Umpan Balik Dan Catatan Asesmen';
    }

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);

        $hasil = HasilUmpanBalik::query()
            ->where('asesmen_umpan_balik_id', $this->record->umpanBalik?->id)
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
                    'asesmen_id' => $this->record->id,
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
}
