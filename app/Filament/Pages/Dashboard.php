<?php

namespace App\Filament\Pages;

class Dashboard extends \Filament\Pages\Dashboard
{
    public static function shouldRegisterNavigation(): bool
    {
        return ! auth()->user()->isAsesi;
    }

    public function mount(): void
    {
        abort_if(auth()->user()->isAsesi, 403);
    }
}
