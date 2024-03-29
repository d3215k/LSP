<?php

namespace App\Filament\Pages\Asesi;

use App\Enums\AsesmenStatus;
use Filament\Pages\Page;

class Beranda extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.asesi.beranda';

    public $showAsesmenSaya = false;

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->isAsesi;
    }

    public function mount(): void
    {
        abort_unless(auth()->user()->isAsesi, 403);

        $this->showAsesmenSaya = auth()->user()->asesi->asesmen()->exists();

    }
}
