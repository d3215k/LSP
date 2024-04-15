<?php

namespace App\Filament\Resources\AsesmenResource\Pages;

use App\Filament\Resources\AsesmenResource;
use App\Models\Asesmen\JawabanTertulisPilihanGanda;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class PertanyaanTertulisPilihanGandaPage extends Page
{
    use InteractsWithRecord;

    protected static string $resource = AsesmenResource::class;

    protected static string $view = 'filament.resources.asesmen-resource.pages.pertanyaan-tertulis-pilihan-ganda-page';

    protected static ?string $title = 'FR.IA.05';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public ?array $data = [];

    public $isShow = false;

    public function getHeading(): string
    {
        return $this->getRecord()->asesi->nama;
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Pertanyaan Tertulis Pilihan Ganda';
    }

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $this->isShow = $this->getRecord()->skema->tertulis_pilihan_ganda && $this->getRecord()->tertulisPilihanGanda;
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

}
