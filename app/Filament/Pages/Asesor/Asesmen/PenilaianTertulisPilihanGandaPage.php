<?php

namespace App\Filament\Pages\Asesor\Asesmen;

use App\Models\Asesmen;
use App\Models\Asesmen\JawabanTertulisPilihanGanda;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Pages\Page;

class PenilaianTertulisPilihanGandaPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.asesor.asesmen.penilaian-tertulis-pilihan-ganda-page';

    protected static ?string $slug = 'asesmen/{record}/penilaian-asesmen-tertulis-pilihan-ganda';

    protected ?string $subheading = 'FR.IA.05 PERTANYAAN TERTULIS PILIHAN GANDA';

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

        $this->record->load(
            'tertulisPilihanGanda',
            'observasiAktivitas',
            'observasiPendukung',

        );
    }

    protected function getViewData(): array
    {
        $this->record->load(
            'skema',
            'skema.unit',
            'skema.unit.pertanyaanTertulisPilihanGanda',
            'skema.unit.pertanyaanTertulisPilihanGanda.pilihanJawaban',
        );

        $hasil = JawabanTertulisPilihanGanda::query()
            ->where('asesmen_tertulis_pilihan_ganda_id', $this->record->tertulisPilihanGanda?->id)
            ->get();

        $this->data['jawaban'] = $hasil->pluck('pilihan_jawaban_id', 'pertanyaan_tertulis_pilihan_ganda_id')->toArray();
        $this->data['kompeten'] = $hasil->pluck('kompeten', 'pertanyaan_tertulis_pilihan_ganda_id')->toArray();
        $this->data['jumlah']['pertanyaan'] = $this->record->skema->pertanyaanTertulisPilihanGanda->count();
        $this->data['jumlah']['K'] = $hasil->where('kompeten', true)->count();
        $this->data['jumlah']['BK'] = $hasil->where('kompeten', false)->count();

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
                    ->url(fn (): string => route('filament.app.pages.asesmen.{record}.penilaian-asesmen-tertulis-pilihan-ganda', $this->record))
                    ->icon('heroicon-m-document-text')
                    ->hidden(fn (): bool => !$this->record->tertulisPilihanGanda),
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

}
