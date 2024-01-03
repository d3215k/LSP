<?php

namespace App\Filament\Pages\Asesor\Asesmen;

use App\Enums\AsesmenStatus;
use App\Enums\RekomendasiRekamanAsesmen;
use App\Models\Asesmen;
use App\Models\Asesmen\HasilObservasiAktivitas;
use App\Models\Asesmen\HasilObservasiPendukung;
use App\Models\Asesmen\HasilRekaman;
use App\Models\Asesmen\JawabanTertulisEsai;
use App\Models\Asesmen\ObservasiAktivitas;
use App\Models\Asesmen\ObservasiPendukung;
use App\Models\Asesmen\Persetujuan;
use App\Models\Asesmen\Rekaman;
use App\Models\Asesmen\TertulisEsai;
use App\Models\Sertifikat;
use App\Models\TempatUjiKompetensi;
use App\Settings\SertifikatSetting;
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

class RekamanPage extends Page implements HasForms, HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.asesor.asesmen.rekaman-page';

    protected static ?string $slug = 'asesmen/{record}/rekaman';

    protected static ?string $title = 'FR.AK.02';

    protected ?string $subheading = 'REKAMAN ASESMEN KOMPETENSI';

    protected static ?int $navigationSort = 4;

    protected static bool $shouldRegisterNavigation = false;

    public ?Asesmen $record;

    public ?array $data = [];
    public ?array $state = [];

    public function mount()
    {
        abort_unless(auth()->user()->isAsesor, 403);

        $this->form->fill($this->record->rekaman?->toArray());

        $hasil = HasilRekaman::query()
            ->where('asesmen_rekaman_id', $this->record->rekaman?->id)
            ->get();

        $this->state['observasi_demonstrasi'] = $hasil->pluck('observasi_demonstrasi', 'unit_id')->toArray();
        $this->state['portofolio'] = $hasil->pluck('portofolio', 'unit_id')->toArray();
        $this->state['pernyataan_pihak_ketiga_pertanyaan_wawancara'] = $hasil->pluck('pernyataan_pihak_ketiga_pertanyaan_wawancara', 'unit_id')->toArray();
        $this->state['pertanyaan_lisan'] = $hasil->pluck('pertanyaan_lisan', 'unit_id')->toArray();
        $this->state['pertanyaan_tertulis'] = $hasil->pluck('pertanyaan_tertulis', 'unit_id')->toArray();
        $this->state['proyek_kerja'] = $hasil->pluck('proyek_kerja', 'unit_id')->toArray();
        $this->state['lainnya'] = $hasil->pluck('lainnya', 'unit_id')->toArray();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('tanggal_mulai')
                    ->inlineLabel()
                    ->required(),
                Forms\Components\DatePicker::make('tanggal_selesai')
                    ->inlineLabel()
                    ->required(),
                Forms\Components\Radio::make('rekomendasi')
                    ->label('Rekomendasi hasil asesmen')
                    ->inlineLabel()
                    ->options(RekomendasiRekamanAsesmen::class)
                    ->inline()
                    ->required(),
                Forms\Components\Textarea::make('tindak_lanjut')
                    ->label('Tindak lanjut yang dibutuhkan')
                    ->placeholder('Masukkan pekerjaan tambahan dan asesmen yang diperlukan untuk mencapai kompetensi')
                    ->inlineLabel(),
                Forms\Components\Textarea::make('catatan')
                    ->label('Komentar / Observasi oleh Asesor')
                    ->inlineLabel(),
            ])
            ->statePath('data');
    }

    public function handleSave()
    {
        $data = $this->form->getState();

        try {
            DB::beginTransaction();
            $esai = Rekaman::updateOrCreate(
                [
                    'asesmen_id' => $this->record->id,
                ],
                $data,
            );

            $state = [];

            foreach (
                array_keys(
                    $this->state['observasi_demonstrasi']
                    + $this->state['portofolio']
                    + $this->state['pernyataan_pihak_ketiga_pertanyaan_wawancara']
                    + $this->state['pertanyaan_lisan']
                    + $this->state['pertanyaan_tertulis']
                    + $this->state['proyek_kerja']
                    + $this->state['lainnya']
                ) as $key) {
                $state[$key] = [
                    'observasi_demonstrasi' => $this->state['observasi_demonstrasi'][$key] ?? false,
                    'portofolio' => $this->state['portofolio'][$key] ?? false,
                    'pernyataan_pihak_ketiga_pertanyaan_wawancara' => $this->state['pernyataan_pihak_ketiga_pertanyaan_wawancara'][$key] ?? false,
                    'pertanyaan_lisan' => $this->state['pertanyaan_lisan'][$key] ?? false,
                    'pertanyaan_tertulis' => $this->state['pertanyaan_tertulis'][$key] ?? false,
                    'proyek_kerja' => $this->state['proyek_kerja'][$key] ?? false,
                    'lainnya' => $this->state['lainnya'][$key] ?? false,
                ];
            }

            foreach ($state as $key => $value) {
                HasilRekaman::updateOrCreate(
                    [
                        'asesmen_rekaman_id' => $esai->id,
                        'unit_id' => $key,
                    ],
                    [
                        'observasi_demonstrasi' => $value['observasi_demonstrasi'],
                        'portofolio' => $value['portofolio'],
                        'pernyataan_pihak_ketiga_pertanyaan_wawancara' => $value['pernyataan_pihak_ketiga_pertanyaan_wawancara'],
                        'pertanyaan_lisan' => $value['pertanyaan_lisan'],
                        'pertanyaan_tertulis' => $value['pertanyaan_tertulis'],
                        'proyek_kerja' => $value['proyek_kerja'],
                        'lainnya' => $value['lainnya'],
                    ]
                );
            }

            $this->record->update([
                'status' => $data['rekomendasi'] === RekomendasiRekamanAsesmen::KOMPETEN->value
                            ? AsesmenStatus::SELESAI_KOMPETEN
                            : ($data['rekomendasi'] === RekomendasiRekamanAsesmen::BELUM_KOMPETEN->value && $data['tindak_lanjut']
                                ? AsesmenStatus::SELESAI_BELUM_KOMPETEN_PERLU_TINDAK_LANJUT
                                : AsesmenStatus::SELESAI_BELUM_KOMPETEN),
            ]);

            if ($data['rekomendasi'] === RekomendasiRekamanAsesmen::KOMPETEN->value) {
                $sertifikat = new SertifikatSetting;

                Sertifikat::updateOrCreate(
                    [
                        'asesmen_id' => $this->record->id,
                    ],
                    [
                        'no_sertifikat' => '71202 3111 2 0000001 2022',
                        'pemilik' => $this->record->rincianDataPemohon->nama,
                        'bidang' => $this->record->skema->bidang,
                        'kompetensi' => $this->record->skema->nama,
                        'unit' => $this->record->skema->unit,
                        'tanggal_terbit' => today(),

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
