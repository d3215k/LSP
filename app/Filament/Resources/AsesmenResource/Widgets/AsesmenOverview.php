<?php

namespace App\Filament\Resources\AsesmenResource\Widgets;

use App\Enums\AsesmenStatus;
use App\Models\Asesmen;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AsesmenOverview extends BaseWidget
{
    protected function getColumns(): int
    {
        return 1;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Pendaftaran Belum Disetujui', Asesmen::where('status', AsesmenStatus::REGISTRASI)->count())
        ];
    }
}
