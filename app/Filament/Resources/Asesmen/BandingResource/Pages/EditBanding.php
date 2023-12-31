<?php

namespace App\Filament\Resources\Asesmen\BandingResource\Pages;

use App\Filament\Resources\Asesmen\BandingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBanding extends EditRecord
{
    protected static string $resource = BandingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
