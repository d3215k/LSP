<?php

namespace App\Filament\Resources\Asesmen\KomponenUmpanBalikResource\Pages;

use App\Filament\Resources\Asesmen\KomponenUmpanBalikResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageKomponenUmpanBaliks extends ManageRecords
{
    protected static string $resource = KomponenUmpanBalikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
