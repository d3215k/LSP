<?php

namespace App\Filament\Widgets;

use App\Models\Asesi;
use App\Models\Asesmen;
use App\Models\Asesor;
use App\Models\Skema;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Skema', Skema::count()),
            Stat::make('Asesor', Asesor::count()),
            Stat::make('Asesi', Asesi::count()),
            Stat::make('Asesmen', Asesmen::count()),
        ];
    }

    public static function canView(): bool
    {
        return auth()->user()->isAdmin;
    }
}
