<?php

namespace App\Filament\Pages\Asesor;

use App\Models\Asesmen\Mandiri;
use Filament\Pages\Page;

class NilaiAsesmenMandiri extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.asesor.nilai-asesmen-mandiri';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public Mandiri $mandiri;

    public function mount(Mandiri $mandiri)
    {
        abort_unless(auth()->user()->isAsesor, 403);

        if (!$mandiri) {
            return to_route('filament.app.pages.dashboard');
        }
    }
}
