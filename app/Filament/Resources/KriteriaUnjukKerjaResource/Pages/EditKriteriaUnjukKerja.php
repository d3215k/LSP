<?php

namespace App\Filament\Resources\KriteriaUnjukKerjaResource\Pages;

use App\Filament\Resources\KriteriaUnjukKerjaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKriteriaUnjukKerja extends EditRecord
{
    protected static string $resource = KriteriaUnjukKerjaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
