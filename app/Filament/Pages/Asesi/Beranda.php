<?php

namespace App\Filament\Pages\Asesi;

use App\Enums\AsesmenStatus;
use Filament\Pages\Page;

class Beranda extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.asesi.beranda';

    public $showPendaftaranAsesmenBaru = false;

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->isAsesi;
    }

    public function mount(): void
    {
        abort_unless(auth()->user()->isAsesi, 403);

        $this->showPendaftaranAsesmenBaru =
            ! auth()->user()->asesi->asesmen()->exists() OR
            auth()->user()->asesi->asesmen()->whereIn(
                'status', [
                    AsesmenStatus::DITOLAK,
                    AsesmenStatus::SELESAI_KOMPETEN,
                    AsesmenStatus::SELESAI_BELUM_KOMPETEN,
                    AsesmenStatus::SELESAI_BELUM_KOMPETEN_PERLU_TINDAK_LANJUT
                ])->exists();
    }
}
