<?php

namespace App\Filament\Pages\Asesor\AsesmenMandiri;

use App\Models\Asesmen\Mandiri;
use Filament\Pages\Page;

class PenilaianAsesmenMandiri extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.asesor.asesmen-mandiri.penilaian-asesmen-mandiri';

    protected static ?string $slug = 'asesmen-mandiri/{record}/penilaian';

    protected ?string $subheading = 'FR.APL.02 Penilaian Asesmen Mandiri';

	protected static bool $shouldRegisterNavigation = false;

    public Mandiri $record;

    public function getHeading(): string
    {
        return $this->record->asesmen->asesi->nama;
    }

    public function mount()
    {
        abort_unless(
            auth()->user()->isAsesor && $this->record->asesmen->asesor_id === auth()->user()->asesor_id,
            403
        );

    }
}
