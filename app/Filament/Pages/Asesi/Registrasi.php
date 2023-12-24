<?php

namespace App\Filament\Pages\Asesi;

use App\Enums\AsesmenStatus;
use App\Models\Asesmen;
use Filament\Pages\Page;

class Registrasi extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.asesi.registrasi';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public $asesmen;

    public function mount(): void
    {
        abort_unless(auth()->user()->isAsesi, 403);

        $this->asesmen = Asesmen::query()
            ->where('asesi_id', auth()->user()->asesi->id)
            ->where('status', AsesmenStatus::REGISTRASI)
            ->first();
    }
}
