<?php

namespace App\Filament\Pages\Asesi;

use App\Enums\AsesmenStatus;
use App\Models\Asesmen;
use App\Models\Asesmen\HasilObservasiAktivitas;
use App\Models\Asesmen\HasilObservasiPendukung;
use App\Models\Asesmen\JawabanTertulisEsai;
use App\Models\Asesmen\ObservasiAktivitas;
use App\Models\Asesmen\ObservasiPendukung;
use App\Models\Asesmen\Persetujuan;
use App\Models\Asesmen\TertulisEsai;
use App\Models\TempatUjiKompetensi;
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

class AsesmenTertulisEsaiPage extends Page implements HasForms, HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.asesi.asesmen-tertulis-esai-page';

    protected static ?string $slug = 'asesi/{record}/asesmen-tertulis-esai';

    protected static ?string $title = 'FR.IA.06';

    protected ?string $subheading = 'PERTANYAAN TERTULIS ESAI';

    protected static ?int $navigationSort = 4;

	public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public Asesmen $record;

    public ?array $data = [];

    public function mount()
    {
        abort_unless(
            auth()->user()->isAsesi
        , 403);

        $hasil = JawabanTertulisEsai::query()
            ->where('asesmen_tertulis_esai_id', $this->record->tertulisEsai?->id)
            ->get();

        $this->data['jawaban'] = $hasil->pluck('jawaban', 'pertanyaan_tertulis_esai_id')->toArray();

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

            foreach (array_keys($this->data['jawaban']) as $key) {
                $data[$key] = [
                    "jawaban" => $this->data['jawaban'][$key] ?? null,
                ];
            }


            foreach ($data as $key => $value) {
                JawabanTertulisEsai::updateOrCreate(
                    [
                        'asesmen_tertulis_esai_id' => $esai->id,
                        'pertanyaan_tertulis_esai_id' => $key,
                    ],
                    [
                        'jawaban' => $value['jawaban'],
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
