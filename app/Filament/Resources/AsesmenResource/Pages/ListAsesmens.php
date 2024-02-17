<?php

namespace App\Filament\Resources\AsesmenResource\Pages;

use App\Filament\Resources\AsesmenResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAsesmens extends ListRecords
{
    protected static string $resource = AsesmenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            AsesmenResource\Widgets\AsesmenOverview::class,
        ];
    }
}
