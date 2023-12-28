<?php

namespace App\Filament\Pages\Asesor;

use App\Models\Asesmen;
use Filament\Pages\Page;

class PersetujuanAsesmenDanKerahasiaan extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.asesor.persetujuan-asesmen-dan-kerahasiaan';

    protected static ?string $slug = 'persetujuan-asesmen-dan-kerahasiaan/{record}';

    protected static ?string $title = 'FR.AK.01';

    protected ?string $subheading = 'Persetujuan Asesmen Dan Kerahasiaan';

	protected static bool $shouldRegisterNavigation = false;

    public Asesmen $record;

    public function mount(Asesmen $record)
    {
        abort_unless(
            auth()->user()->isAsesor && $record->asesor_id === auth()->user()->asesor_id,
            403
        );

        $this->record = $record;

    }
}
