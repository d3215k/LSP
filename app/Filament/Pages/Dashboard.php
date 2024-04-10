<?php

namespace App\Filament\Pages;

class Dashboard extends \Filament\Pages\Dashboard
{
    public static function shouldRegisterNavigation(): bool
    {
        return ! auth()->user()->isAsesi;
    }

    public function mount()
    {
        if (auth()->user()->isAsesi) {
            return to_route('asesi.beranda');
        }
    }
}
