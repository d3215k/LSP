<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Enums\UserType;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('User Sedang Login', User::where('last_login', '>=', now()->subMinutes(15))->count()),
            Stat::make('Admin', User::query()->where('type', UserType::ADMIN)->count()),
            Stat::make('Asesor', User::query()->where('type', UserType::ASESOR)->count()),
            Stat::make('Asesi', User::query()->where('type', UserType::ASESI)->count()),
        ];
    }
}
