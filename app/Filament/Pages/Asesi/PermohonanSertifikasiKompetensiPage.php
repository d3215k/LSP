<?php

namespace App\Filament\Pages\Asesi;

use App\Enums\AsesmenStatus;
use App\Models\Asesmen;
use Filament\Pages\Page;

class PermohonanSertifikasiKompetensiPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.asesi.permohonan-sertifikasi-kompetensi-page';

    protected static ?string $slug = 'asesi/{record}/permohonan-sertifikasi-kompetensi';

    protected static ?string $title = 'FR.APL.01';

    protected ?string $subheading = ' PERMOHONAN SERTIFIKASI KOMPETENSI';

    protected static ?int $navigationSort = 4;

    public Asesmen $record;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function mount()
    {
        abort_unless(
            auth()->user()->isAsesi && $this->record->asesi_id === auth()->user()->asesi->id
        , 403);
    }
}
