<?php

namespace App\Filament\Pages\Asesor\Asesmen;

use App\Enums\AsesmenStatus;
use App\Models\Asesmen;
use App\Models\Asesmen\JawabanTertulisEsai;
use App\Models\Asesmen\TertulisEsai;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class PenilaianTertulisEsaiPage extends Page implements HasForms, HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.asesor.asesmen.penilaian-tertulis-esai-page';

    protected static ?string $slug = 'asesmen/{record}/penilaian-asesmen-tertulis-esai';

    protected ?string $subheading = 'FR.IA.06 PERTANYAAN TERTULIS';

    protected static ?int $navigationSort = 4;

    protected static bool $shouldRegisterNavigation = false;

    public ?Asesmen $record;

    public ?array $data = [];

    public function getHeading(): string
    {
        return $this->record->asesi->nama;
    }

    public function mount()
    {
        abort_unless(
            auth()->user()->isAsesor && $this->record->asesor_id === auth()->user()->asesor_id
        , 403);

    }

    protected function getViewData(): array
    {
        $this->record->load('skema', 'skema.unit', 'skema.unit.pertanyaanTertulisEsai');

        $hasil = JawabanTertulisEsai::query()
            ->where('asesmen_tertulis_esai_id', $this->record->tertulisEsai?->id)
            ->get();

        $this->data['jawaban'] = $hasil->pluck('jawaban', 'pertanyaan_tertulis_esai_id')->toArray();
        $this->data['kompeten'] = $hasil->pluck('kompeten', 'pertanyaan_tertulis_esai_id')->toArray();

        return [];
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
                    ->hidden(fn (): bool => !$this->record->tertulisEsai()->exists()),
                Action::make('Rekaman')
                    ->url(fn (): string => route('filament.app.pages.asesmen.{record}.rekaman', $this->record))
                    ->icon('heroicon-m-document-text')
                    ->hidden(fn (): bool => !$this->record->observasiAktivitas()->exists() || !$this->record->observasiPendukung()->exists()),
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
