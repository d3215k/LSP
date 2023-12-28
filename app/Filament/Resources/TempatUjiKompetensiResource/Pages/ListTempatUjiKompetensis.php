<?php

namespace App\Filament\Resources\TempatUjiKompetensiResource\Pages;

use App\Filament\Resources\TempatUjiKompetensiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTempatUjiKompetensis extends ListRecords
{
    protected static string $resource = TempatUjiKompetensiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
