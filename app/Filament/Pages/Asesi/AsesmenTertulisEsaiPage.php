<?php

namespace App\Filament\Pages\Asesi;

use App\Models\Asesmen;
use App\Models\Asesmen\JawabanTertulisEsai;
use App\Models\Asesmen\TertulisEsai;
use Filament\Forms;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;

class AsesmenTertulisEsaiPage extends Page implements HasForms, HasInfolists, HasActions
{
    use InteractsWithActions;
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

    public ?TertulisEsai $tertulisEsai;

    public function mount()
    {
        abort_unless(
            auth()->user()->isAsesi && $this->record->asesi_id === auth()->user()->asesi_id
        , 403);

        $this->tertulisEsai = TertulisEsai::firstOrCreate(
            [
                'asesmen_id' => $this->record->id,
            ],
            [
                'tanggal_asesmen' => today(),
            ]
        );
    }

    protected function getViewData(): array
    {
        $this->record->load('skema', 'skema.unit', 'skema.unit.pertanyaanTertulisEsai');

        $hasil = JawabanTertulisEsai::query()
            ->where('asesmen_tertulis_esai_id', $this->record->tertulisEsai?->id)
            ->get();

        return [
            'jawaban' => $hasil->pluck('jawaban', 'pertanyaan_tertulis_esai_id')->toArray(),
        ];
    }

    public function jawabAction(): Action
    {
        return Action::make('jawab')
            ->label('Jawab')
            ->form(function (array $arguments) {
                return [
                    RichEditor::make('jawaban')
                        ->default($arguments['jawaban'])
                        ->required(),
                ];
            })
            ->closeModalByClickingAway(false)
            ->modalHeading('Pertanyaan')
            ->modalDescription(fn (array $arguments): string | Htmlable => new HtmlString( '<div class="max-w-screen-md p-4 prose dark:prose-invert bg-white dark:bg-gray-900">'.$arguments['pertanyaan'].'</div>'))
            ->action(function (array $data, array $arguments) {
                try {
                    DB::beginTransaction();
                    JawabanTertulisEsai::updateOrCreate(
                        [
                            'asesmen_tertulis_esai_id' => $this->tertulisEsai->id,
                            'pertanyaan_tertulis_esai_id' => $arguments['pertanyaanId'],
                        ],
                        [
                            'jawaban' => $data['jawaban'],
                        ],
                    );
                    DB::commit();
                    Notification::make()->title('Jawaban Tersimpan')->success()->send();

                } catch (\Throwable $th) {
                    report($th->getMessage());
                    Notification::make()->title('Whoops! Ada yang salah')->danger()->send();
                    DB::rollBack();
                }
            });
    }
}
