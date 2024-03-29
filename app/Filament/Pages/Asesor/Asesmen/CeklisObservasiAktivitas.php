<?php

namespace App\Filament\Pages\Asesor\Asesmen;

use App\Enums\AsesmenStatus;
use App\Models\Asesmen;
use App\Models\Asesmen\HasilObservasiAktivitas;
use App\Models\Asesmen\ObservasiAktivitas;
use App\Models\Skema\Elemen;
use App\Models\Skema\KriteriaUnjukKerja;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Livewire\Attributes\Computed;

class CeklisObservasiAktivitas extends Page implements HasForms, HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.asesor.asesmen.ceklis-observasi-aktivitas';

    protected static ?string $slug = 'asesmen/{record}/ceklis-observasi-aktivitas';

    protected ?string $subheading = 'FR.IA.01 CEKLIS OBSERVASI AKTIVITAS DI TEMPAT KERJA ATAU TEMPAT KERJA SIMULASI';

	protected static bool $shouldRegisterNavigation = false;

    public Asesmen $record;

    public ?array $data = [];

    public function getHeading(): string
    {
        return $this->record->asesi->nama;
    }

    public function mount(): void
    {
        abort_unless(
            auth()->user()->isAsesor && $this->record->asesor_id === auth()->user()->asesor_id,
            403
        );

        $this->record->load('skema', 'skema.unit', 'skema.unit.elemen', 'skema.unit.elemen.kriteriaUnjukKerja', 'tertulisEsai', 'observasiAktivitas', 'observasiPendukung');

        $hasil = HasilObservasiAktivitas::query()
            ->where('asesmen_observasi_aktivitas_id', $this->record->observasiAktivitas?->id)
            ->get();

        $this->data['kompeten'] = $hasil->pluck('kompeten', 'kriteria_unjuk_kerja_id')->toArray();

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
        foreach ($this->kukIds as $id) {
            $this->data['kompeten'][$id] = $kompeten ? 'K' : 'BK';
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                Action::make('Observasi Aktivitas')
                    ->url(fn (): string => route('filament.app.pages.asesmen.{record}.ceklis-observasi-aktivitas', $this->record))
                    ->icon('heroicon-m-document-text'),
                Action::make('Observasi Pendukung')
                    ->url(fn (): string => route('filament.app.pages.asesmen.{record}.pertanyaan-observasi-pendukung', $this->record))
                    ->icon('heroicon-m-document-text'),
                 Action::make('Tertulis')
                    ->url(fn (): string => route('filament.app.pages.asesmen.{record}.penilaian-asesmen-tertulis-esai', $this->record))
                    ->icon('heroicon-m-document-text')
                    ->hidden(fn (): bool => !$this->record->tertulisEsai),
                Action::make('Rekaman')
                    ->url(fn (): string => route('filament.app.pages.asesmen.{record}.rekaman', $this->record))
                    ->icon('heroicon-m-document-text')
                    ->hidden(fn (): bool => !$this->record->observasiAktivitas || !$this->record->observasiPendukung),
            ])
            ->button()
            ->icon('heroicon-m-document-text')
            ->label('Penilaian')
        ];
    }

    public function handleSave()
    {
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

            // dd($data, $observasi);

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
