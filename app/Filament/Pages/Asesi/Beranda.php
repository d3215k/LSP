<?php

namespace App\Filament\Pages\Asesi;

use Filament\Pages\Page;

class Beranda extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.asesi.beranda';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->isAsesi;
    }

    public function mount(): void
    {
        abort_unless(auth()->user()->isAsesi, 403);
    }
}
