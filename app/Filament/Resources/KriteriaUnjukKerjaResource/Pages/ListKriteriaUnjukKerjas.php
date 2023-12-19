<?php

namespace App\Filament\Resources\KriteriaUnjukKerjaResource\Pages;

use App\Filament\Resources\KriteriaUnjukKerjaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKriteriaUnjukKerjas extends ListRecords
{
    protected static string $resource = KriteriaUnjukKerjaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
