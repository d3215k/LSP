<?php

namespace App\Filament\Pages\Asesor\Asesmen;

use App\Enums\AsesmenStatus;
use App\Models\Asesmen;
use App\Models\Asesmen\HasilObservasiAktivitas;
use App\Models\Asesmen\ObservasiAktivitas;
use App\Models\Asesmen\Persetujuan;
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

class PertanyaanObservasiPendukung extends Page implements HasForms, HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.asesor.asesmen.pertanyaan-observasi-pendukung';

    protected static ?string $slug = 'asesmen/{record}/pertanyaan-observasi-pendukung';

    protected static ?string $title = 'FR.IA.03';

    protected ?string $subheading = 'PERTANYAAN OBSERVASI PENDUKUNG';

	protected static bool $shouldRegisterNavigation = false;

    public Asesmen $record;

    public ?array $data = [];

    public function mount(Asesmen $record): void
    {
        abort_unless(
            auth()->user()->isAsesor && $record->asesor_id === auth()->user()->asesor_id,
            403
        );

        // dd($record->observasiAktivitas->id);

        $hasil = HasilObservasiAktivitas::query()
            ->where('asesmen_observasi_aktivitas_id', $record->observasiAktivitas->id)
            ->get();

        // dd($hasil);

        $this->data['kompeten'] = $hasil->pluck('kompeten', 'kriteria_unjuk_kerja_id')->toArray();

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
            Notification::make()->title('Asesmen Mandiri Tersimpan')->success()->send();

        } catch (\Throwable $th) {
            $th->getMessage();
            Notification::make()->title('Whoops! Ada yang salah')->danger()->send();
            DB::rollBack();
        }
    }
}
