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

    protected ?string $subheading = ' ASESMEN MANDIRI';

    protected static ?string $slug = 'asesi/{record}/asesmen-mandiri';

    protected static ?int $navigationSort = 4;

    public Asesmen $record;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function mount()
    {
        abort_unless(
            auth()->user()->isAsesi
        , 403);
    }

}
