<?php

namespace App\Filament\Resources\AsesmenResource\Pages;

use App\Enums\AsesmenStatus;
use App\Filament\Resources\AsesmenResource;
use App\Models\Asesmen\JawabanTertulisEsai;
use App\Models\Asesmen\TertulisEsai;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\DB;

class PertanyaanTertulisEsaiPage extends Page
{
    use InteractsWithRecord;

    protected static string $resource = AsesmenResource::class;

    protected static string $view = 'filament.resources.asesmen-resource.pages.pertanyaan-tertulis-esai-page';

    protected static ?string $title = 'FR.IA.06';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public ?array $data = [];

    public $isShow = false;

    public function getHeading(): string
    {
        return $this->getRecord()->asesi->nama;
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Pertanyaan Tertulis Esai';
    }

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $this->isShow = $this->getRecord()->skema->tertulis_esai && isset($this->getRecord()->tertulisEsai);
    }

    protected function getViewData(): array
    {
        $this->record->load('skema', 'tertulisEsai', 'skema.unit', 'skema.unit.pertanyaanTertulisEsai');

        $hasil = JawabanTertulisEsai::query()
            ->where('asesmen_tertulis_esai_id', $this->record->tertulisEsai?->id)
            ->get();

        $this->data['jawaban'] = $hasil->pluck('jawaban', 'pertanyaan_tertulis_esai_id')->toArray();
        $this->data['kompeten'] = $hasil->pluck('kompeten', 'pertanyaan_tertulis_esai_id')->toArray();

        return [];
    }

    public function handleSave()
    {
        try {
            DB::beginTransaction();
            $esai = TertulisEsai::updateOrCreate(
                [
                    'asesmen_id' => $this->record->id,
                ],
                [
                    'tanggal_asesmen' => today(),
                ]
            );

            $data = [];

            foreach (array_keys($this->data['kompeten']) as $key) {
                $data[$key] = [
                    'kompeten' => $this->data['kompeten'][$key] ?? null,
                ];
            }


            foreach ($data as $key => $value) {
                JawabanTertulisEsai::updateOrCreate(
                    [
                        'asesmen_tertulis_esai_id' => $esai->id,
                        'pertanyaan_tertulis_esai_id' => $key,
                    ],
                    [
                        'kompeten' => $value['kompeten'],
                    ]
                );
            }

            $this->record->update([
                'status' => AsesmenStatus::TERTULIS_ESAI
            ]);

            DB::commit();
            Notification::make()->title('Data Tersimpan')->success()->send();

        } catch (\Throwable $th) {
            $th->getMessage();
            Notification::make()->title('Whoops! Ada yang salah')->danger()->send();
            DB::rollBack();
        }
    }

}
