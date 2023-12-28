<?php

namespace App\Filament\Pages\Asesor;

use App\Models\Asesmen\Mandiri;
use Filament\Pages\Page;

class NilaiAsesmenMandiri extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.asesor.nilai-asesmen-mandiri';

    protected static ?string $slug = 'nilai-asesmen-mandiri/{mandiri}';

    protected ?string $heading = 'Penilaian Asesmen Mandiri';

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
