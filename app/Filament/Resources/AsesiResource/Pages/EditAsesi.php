<?php

namespace App\Filament\Resources\AsesiResource\Pages;

use App\Filament\Resources\AsesiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAsesi extends EditRecord
{
    protected static string $resource = AsesiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
