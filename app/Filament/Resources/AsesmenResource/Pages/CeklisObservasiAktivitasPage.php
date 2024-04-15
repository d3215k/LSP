<?php

namespace App\Filament\Resources\AsesmenResource\Pages;

use App\Enums\AsesmenStatus;
use App\Filament\Resources\AsesmenResource;
use App\Models\Asesmen\HasilObservasiAktivitas;
use App\Models\Asesmen\ObservasiAktivitas;
use App\Models\Skema\Elemen;
use App\Models\Skema\KriteriaUnjukKerja;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;

class CeklisObservasiAktivitasPage extends Page implements HasForms, HasInfolists
{
    use InteractsWithRecord;
    use InteractsWithInfolists;
    use InteractsWithForms;

    protected static string $resource = AsesmenResource::class;

    protected static string $view = 'filament.resources.asesmen-resource.pages.ceklis-observasi-aktivitas-page';

    protected static ?string $title = 'FR.IA.01';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public ?array $data = [];

    public $isShow = false;

    public function getHeading(): string
    {
        return $this->record->asesi->nama;
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Ceklis Observasi Aktivitas Di Tempat Kerja atau Tempat Kerja Simulasi';
    }

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $this->isShow = $this->getRecord()->status->value >= AsesmenStatus::PERSETUJUAN->value;

        $this->record->load('skema', 'skema.unit', 'skema.unit.elemen', 'skema.unit.elemen.kriteriaUnjukKerja', 'tertulisEsai', 'observasiAktivitas', 'observasiPendukung');

        $hasil = HasilObservasiAktivitas::query()
            ->where('asesmen_observasi_aktivitas_id', $this->record->observasiAktivitas?->id)
            ->get();

        $this->data['kompeten'] = $hasil->pluck('kompeten', 'kriteria_unjuk_kerja_id')->toArray();
        // $this->form->fill($this->getRecord()->persetujuan?->toArray());
    }

    #[Computed()]
    public function kukIds()
    {
        $uids = $this->record->skema->unit->pluck('id');
        $els = Elemen::whereIn('unit_id', $uids)->pluck('id');
        $kuk = KriteriaUnjukKerja::whereIn('elemen_id', $els)->pluck('id');
        return $kuk;
    }

    public function setRekomendasiKompetensiTo($kompeten = true)
    {
        if (! auth()->user()->isAsesor) {
            return Notification::make()->title('Whoops!')->body('Hanya bisa oleh Asesor')->danger()->send();
        }

        foreach ($this->kukIds as $id) {
            $this->data['kompeten'][$id] = $kompeten ? 'K' : 'BK';
        }
    }

    public function handleSave()
    {
        if (! auth()->user()->isAsesor) {
            return Notification::make()->title('Whoops!')->body('Hanya bisa oleh Asesor')->danger()->send();
        }

        try {
            DB::beginTransaction();
            $observasi = ObservasiAktivitas::updateOrCreate(
                [
                    'asesmen_id' => $this->record->id,
                ],
                [
                    'tanggal' => today(),
                ]
            );

            $data = [];

            foreach (array_keys($this->data['kompeten']) as $key) {
                $data[$key] = [
                    "kompeten" => $this->data['kompeten'][$key] ?? null,
                ];
            }

            foreach ($data as $key => $value) {
                HasilObservasiAktivitas::updateOrCreate(
                    [
                        'asesmen_observasi_aktivitas_id' => $observasi->id,
                        'kriteria_unjuk_kerja_id' => $key,
                    ],
                    [
                        'kompeten' => $value['kompeten'],
                    ]
                );
            }

            $this->record->update([
                'status' => AsesmenStatus::OBSERVASI_AKTIVITAS
            ]);

            DB::commit();
            Notification::make()->title('Data Tersimpan!')->success()->send();

        } catch (\Throwable $th) {
            $th->getMessage();
            Notification::make()->title('Whoops! Ada yang salah')->danger()->send();
            DB::rollBack();
        }
    }
}
