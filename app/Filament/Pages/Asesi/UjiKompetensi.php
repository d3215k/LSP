<?php

namespace App\Filament\Pages\Asesi;

use App\Enums\AsesmenStatus;
use App\Enums\UserType;
use Filament\Pages\Page;

class UjiKompetensi extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.asesi.uji-kompetensi';

    public string $activeTab = 'tab1';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->isAsesi && auth()->user()->asesi->asesmen()->where('status', '>', 1)->exists();
    }

    public function mount(): void
    {
        abort_unless(auth()->user()->isAsesi, 403);
    }

}
