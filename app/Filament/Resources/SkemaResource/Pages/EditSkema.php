<?php

namespace App\Filament\Resources\SkemaResource\Pages;

use App\Filament\Resources\SkemaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSkema extends EditRecord
{
    protected static string $resource = SkemaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
