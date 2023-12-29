<?php

namespace App\Filament\Pages\Asesor\AsesmenMandiri;

use App\Models\Asesmen\Mandiri;
use Filament\Pages\Page;

class PenilaianAsesmenMandiri extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.asesor.asesmen-mandiri.penilaian-asesmen-mandiri';

    protected static ?string $slug = 'asesmen-mandiri/{mandiri}/penilaian';

    protected static ?string $title = 'FR.APL.02';

    protected ?string $subheading = 'Penilaian Asesmen Mandiri';

	protected static bool $shouldRegisterNavigation = false;

    public Mandiri $mandiri;

    public function mount(Mandiri $mandiri)
    {
        abort_unless(
            auth()->user()->isAsesor && $mandiri?->asesmen->asesor_id === auth()->user()->asesor_id,
            403
        );

        $this->mandiri = $mandiri;

    }
}