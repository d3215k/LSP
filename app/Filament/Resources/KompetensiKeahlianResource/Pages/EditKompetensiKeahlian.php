<?php

namespace App\Filament\Resources\KompetensiKeahlianResource\Pages;

use App\Filament\Resources\KompetensiKeahlianResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKompetensiKeahlian extends EditRecord
{
    protected static string $resource = KompetensiKeahlianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
