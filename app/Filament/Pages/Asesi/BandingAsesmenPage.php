<?php

namespace App\Filament\Pages\Asesi;

use App\Enums\AsesmenStatus;
use App\Models\Asesmen;
use App\Models\Asesmen\Banding;
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

class BandingAsesmenPage extends Page implements HasForms, HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.asesi.banding-asesmen-page';

    protected static ?string $slug = 'banding-asesmen';

    protected static ?string $title = 'FR.AK.04';

    protected ?string $subheading = 'BANDING ASESMEN';

    protected static ?int $navigationSort = 4;

	public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->isAsesi && auth()->user()->asesi?->asesmen()->whereIn('status', [AsesmenStatus::SELESAI_BELUM_KOMPETEN, AsesmenStatus::SELESAI_BELUM_KOMPETEN_PERLU_TINDAK_LANJUT])->exists();
    }

    public ?Asesmen $record;

    public ?array $data = [];

    public function mount()
    {
        abort_unless(auth()->user()->isAsesi, 403);

        $this->record = Asesmen::query()
            ->where('asesi_id', auth()->user()->asesi->id)
            ->whereIn('status', [AsesmenStatus::SELESAI_BELUM_KOMPETEN, AsesmenStatus::SELESAI_BELUM_KOMPETEN_PERLU_TINDAK_LANJUT])
            ->first();

        if (! $this->record) {
            return to_route('filament.app.pages.beranda');
        }

        $this->form->fill($this->record->banding?->toArray());

    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Radio::make('telah_dijelaskan')
                    ->boolean('Ya', 'Tidak')
                    ->label('Apakah Proses Banding telah dijelaskan kepada Anda?')
                    // ->inline()
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\Radio::make('telah_diskusi')
                    ->boolean('Ya', 'Tidak')
                    ->label('Apakah Anda telah mendiskusikan Banding dengan Asesor?')
                    // ->inline()
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\Radio::make('melibatkan')
                    ->boolean('Ya', 'Tidak')
                    ->label('Apakah Anda mau melibatkan “orang lain” membantu Anda dalam Proses Banding?')
                    // ->inline()
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\Textarea::make('alasan')
                    ->label('Banding ini diajukan atas alasan sebagai berikut :')
                    ->required()
                    ->columnSpanFull()
            ])
            ->statePath('data');
    }

    public function handleSave()
    {
        try {
            DB::beginTransaction();

            $data = $this->form->getState();
            $data['tanggal'] = today();

            Banding::updateOrCreate(['asesmen_id' => $this->record->id], $data);

            DB::commit();
            Notification::make()->title('Data Tersimpan')->success()->send();

        } catch (\Throwable $th) {
            report($th->getMessage());
            Notification::make()->title('Whoops! Ada yang salah')->danger()->send();
            DB::rollBack();
        }
    }
}
