<?php

namespace App\Filament\Resources\AsesmenResource\Pages;

use App\Enums\AsesmenStatus;
use App\Filament\Resources\AsesmenResource;
use App\Models\Asesmen\HasilObservasiPendukung;
use App\Models\Asesmen\ObservasiPendukung;
use App\Models\Asesmen\PertanyaanObservasiPendukung;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;

class PertanyaanObservasiPendukungPage extends Page
{
    use InteractsWithRecord;

    protected static string $resource = AsesmenResource::class;

    protected static string $view = 'filament.resources.asesmen-resource.pages.pertanyaan-observasi-pendukung-page';

    protected static ?string $title = 'FR.IA.03';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public ?array $data = [];

    public $isShow = false;

    public function getHeading(): string
    {
        return $this->getRecord()->asesi->nama;
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Pertanyaan Pendukung Observasi';
    }

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $this->isShow = $this->getRecord()->status->value >= 3;

        $this->record->load('skema', 'skema.unit', 'skema.unit.pertanyaanObservasiPendukung', 'tertulisEsai', 'observasiAktivitas', 'observasiPendukung');

        $hasil = HasilObservasiPendukung::query()
            ->where('asesmen_observasi_pendukung_id', $this->record->observasiPendukung?->id)
            ->get();

        $this->data['kompeten'] = $hasil->pluck('kompeten', 'pertanyaan_id')->toArray();
        $this->data['tanggapan'] = $hasil->pluck('tanggapan', 'pertanyaan_id')->toArray();

    }

    #[Computed()]
    public function pertanyaanIds()
    {
        $unitIds = $this->record->skema->unit->pluck('id');
        $kuk = PertanyaanObservasiPendukung::whereIn('unit_id', $unitIds)->pluck('id');
        return $kuk;
    }

    public function setRekomendasiKompetensiTo($kompeten = true)
    {
        foreach ($this->pertanyaanIds as $id) {
            $this->data['kompeten'][$id] = $kompeten ? 'K' : 'BK';
        }
    }

    public function handleSave()
    {
        try {
            DB::beginTransaction();
            $observasi = ObservasiPendukung::updateOrCreate(
                [
                    'asesmen_id' => $this->record->id,
                ],
                [
                    'tanggal' => today(),
                ]
            );

            $data = [];

            foreach (array_keys($this->data['kompeten'] + $this->data['tanggapan']) as $key) {
                $data[$key] = [
                    "kompeten" => $this->data['kompeten'][$key] ?? null,
                    "tanggapan" => $this->data['tanggapan'][$key] ?? null,
                ];
            }


            foreach ($data as $key => $value) {
                HasilObservasiPendukung::updateOrCreate(
                    [
                        'asesmen_observasi_pendukung_id' => $observasi->id,
                        'pertanyaan_id' => $key,
                    ],
                    [
                        'kompeten' => $value['kompeten'],
                        'tanggapan' => $value['tanggapan'],
                    ]
                );
            }

            $this->record->update([
                'status' => AsesmenStatus::OBSERVASI_PENDUKUNG
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
