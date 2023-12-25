<?php

namespace App\Filament\Pages\Asesi;

use App\Enums\AsesmenStatus;
use App\Models\Asesmen;
use Filament\Pages\Page;

class Registrasi extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.asesi.registrasi';

    protected static ?string $title = 'FR.APL.01';

    protected ?string $subheading = ' PERMOHONAN SERTIFIKASI KOMPETENSI';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->isAsesi && auth()->user()->asesi?->asesmen()->where('status', AsesmenStatus::REGISTRASI)->exists();
    }

    public $asesmen;

    public function mount()
    {
        abort_unless(auth()->user()->isAsesi, 403);

        $this->asesmen = Asesmen::query()
            ->where('asesi_id', auth()->user()->asesi->id)
            ->where('status', AsesmenStatus::REGISTRASI)
            ->first();

        if (! $this->asesmen) {
            return to_route('filament.app.pages.beranda');
        }
    }
}
