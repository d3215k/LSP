<?php

namespace App\Filament\Pages\Asesi;

use App\Enums\AsesmenStatus;
use App\Models\Asesmen;
use Filament\Pages\Page;

class AsesmenMandiriPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.asesi.asesmen-mandiri-page';

    protected static ?string $title = 'FR.APL.02';

    protected ?string $subheading = 'ASESMEN MANDIRI';

    protected static ?string $slug = 'asesi/asesmen-mandiri';

    protected static ?int $navigationSort = 4;

    public ?Asesmen $asesmen;

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->isAsesi && auth()->user()->asesi?->asesmen()->where('status', AsesmenStatus::ASESMEN_MANDIRI)->exists();
    }

    public function mount()
    {
        abort_unless(auth()->user()->isAsesi, 403);

        $this->asesmen = Asesmen::query()
            ->where('asesi_id', auth()->user()->asesi->id)
            ->where('status', AsesmenStatus::ASESMEN_MANDIRI)
            ->first();

        if (! $this->asesmen) {
            return to_route('filament.app.pages.beranda');
        }
    }

}
