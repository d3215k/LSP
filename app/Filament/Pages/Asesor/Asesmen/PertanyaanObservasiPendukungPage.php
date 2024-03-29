<?php

namespace App\Filament\Pages\Asesor\Asesmen;

use App\Enums\AsesmenStatus;
use App\Models\Asesmen;
use App\Models\Asesmen\HasilObservasiPendukung;
use App\Models\Asesmen\ObservasiPendukung;
use App\Models\Asesmen\PertanyaanObservasiPendukung;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;

class PertanyaanObservasiPendukungPage extends Page implements HasForms, HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.asesor.asesmen.pertanyaan-observasi-pendukung-page';

    protected static ?string $slug = 'asesmen/{record}/pertanyaan-observasi-pendukung';

    protected ?string $subheading = 'FR.IA.03 PERTANYAAN OBSERVASI PENDUKUNG';

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
            auth()->user()->isAsesor && $this->record->asesor_id === auth()->user()->asesor_id ,
            403
        );

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
