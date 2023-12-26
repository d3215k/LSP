<?php

namespace App\Filament\Pages\Asesi;

use App\Enums\AsesmenStatus;
use App\Models\Asesmen;
use Filament\Pages\Page;

class UjiKompetensi extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.asesi.uji-kompetensi';

    public string $activeTab = 'tab2';

    public Asesmen $asesmen;

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->isAsesi && auth()->user()->asesi->asesmen()->where('status', '>', 1)->exists();
    }

    public function mount()
    {
        abort_unless(auth()->user()->isAsesi, 403);

        $this->asesmen = Asesmen::query()
            ->where('asesi_id', auth()->user()->asesi->id)
            ->where('status', AsesmenStatus::ASESMEN_MANDIRI)
            ->first();

        if (! $this->asesmen) {
            return to_route('filament.app.pages.beranda');
        }
    }

}
