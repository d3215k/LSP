<?php

namespace App\Filament\Resources\KompetensiKeahlianResource\Pages;

use App\Filament\Resources\KompetensiKeahlianResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKompetensiKeahlians extends ListRecords
{
    protected static string $resource = KompetensiKeahlianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
