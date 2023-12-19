<?php

namespace App\Filament\Resources\AsesorResource\Pages;

use App\Filament\Resources\AsesorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAsesors extends ListRecords
{
    protected static string $resource = AsesorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
