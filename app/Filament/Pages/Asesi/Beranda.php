<?php

namespace App\Filament\Pages\Asesi;

use App\Enums\AsesmenStatus;
use Filament\Pages\Page;

class Beranda extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.asesi.beranda';

    public $showDaftarAsesmen = false;

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->isAsesi;
    }

    public function mount(): void
    {
        abort_unless(auth()->user()->isAsesi, 403);

        $this->showDaftarAsesmen = ! auth()->user()->asesi->asesmen()->where('status', AsesmenStatus::REGISTRASI)->exists();
    }
}
