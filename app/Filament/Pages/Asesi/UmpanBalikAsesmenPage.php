<?php

namespace App\Filament\Pages\Asesi;

use App\Enums\AsesmenStatus;
use App\Models\Asesmen;
use App\Models\Asesmen\HasilObservasiAktivitas;
use App\Models\Asesmen\HasilObservasiPendukung;
use App\Models\Asesmen\HasilUmpanBalik;
use App\Models\Asesmen\KomponenUmpanBalik;
use App\Models\Asesmen\ObservasiPendukung;
use App\Models\Asesmen\UmpanBalik;
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
use Livewire\Attributes\Computed;

class UmpanBalikAsesmenPage extends Page implements HasForms, HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.asesi.umpan-balik-asesmen-page';

    protected static ?string $slug = 'umpan-balik';

    protected static ?string $title = 'FR.AK.03';

    protected ?string $subheading = 'UMPAN BALIK DAN CATATAN ASESMEN';

    public ?Asesmen $record;

    public ?array $data = [];

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->isAsesi && auth()->user()->asesi?->asesmen()->whereIn('status', [AsesmenStatus::SELESAI_KOMPETEN, AsesmenStatus::SELESAI_BELUM_KOMPETEN_PERLU_TINDAK_LANJUT, AsesmenStatus::SELESAI_BELUM_KOMPETEN])->exists();
    }

    public function mount()
    {
        abort_unless(auth()->user()->isAsesi, 403);

        $this->record = Asesmen::query()
            ->where('asesi_id', auth()->user()->asesi->id)
            ->whereIn('status', [AsesmenStatus::SELESAI_KOMPETEN, AsesmenStatus::SELESAI_BELUM_KOMPETEN_PERLU_TINDAK_LANJUT, AsesmenStatus::SELESAI_BELUM_KOMPETEN])
            ->first();

        if (! $this->record) {
            return to_route('filament.app.pages.beranda');
        }

        $hasil = HasilUmpanBalik::query()
            ->where('asesmen_umpan_balik_id', $this->record->umpanBalik?->id)
            ->get();

        $this->data['hasil'] = $hasil->pluck('hasil', 'komponen_umpan_balik_id')->toArray();
        $this->data['catatan'] = $hasil->pluck('catatan', 'komponen_umpan_balik_id')->toArray();

    }

    #[Computed]
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
