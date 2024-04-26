<?php

namespace App\Filament\Resources\Asesmen\TertulisPilihanGandaResource\Pages;

use App\Filament\Resources\Asesmen\TertulisPilihanGandaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTertulisPilihanGandas extends ListRecords
{
    protected static string $resource = TertulisPilihanGandaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
