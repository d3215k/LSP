<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Asesmen extends Cluster
{
    protected static ?string $navigationGroup = 'Admin';

    protected static ?string $navigationIcon = 'heroicon-o-document-check';

    public static function shouldRegisterNavigation(array $parameters = []): bool
    {
        return auth()->user()->isAdmin;
    }
}
