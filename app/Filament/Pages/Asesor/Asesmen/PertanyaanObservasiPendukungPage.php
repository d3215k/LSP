<?php

namespace App\Filament\Pages\Asesor\Asesmen;

use App\Enums\AsesmenStatus;
use App\Models\Asesmen;
use App\Models\Asesmen\HasilObservasiAktivitas;
use App\Models\Asesmen\HasilObservasiPendukung;
use App\Models\Asesmen\ObservasiAktivitas;
use App\Models\Asesmen\ObservasiPendukung;
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

class PertanyaanObservasiPendukungPage extends Page implements HasForms, HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.asesor.asesmen.pertanyaan-observasi-pendukung-page';

    protected static ?string $slug = 'asesmen/{record}/pertanyaan-observasi-pendukung';

    protected static ?string $title = 'FR.IA.03';

    protected ?string $subheading = 'PERTANYAAN OBSERVASI PENDUKUNG';

	protected static bool $shouldRegisterNavigation = false;

    public Asesmen $record;

    public ?array $data = [];

    public function mount(Asesmen $record): void
    {
        abort_unless(
            auth()->user()->isAsesor  ,
            403
        );

        // dd($record->observasiAktivitas->id);

        $hasil = HasilObservasiPendukung::query()
            ->where('asesmen_observasi_pendukung_id', $record->observasiPendukung?->id)
            ->get();

        // dd($hasil);

        $this->data['kompeten'] = $hasil->pluck('kompeten', 'pertanyaan_id')->toArray();
        $this->data['tanggapan'] = $hasil->pluck('tanggapan', 'pertanyaan_id')->toArray();

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
