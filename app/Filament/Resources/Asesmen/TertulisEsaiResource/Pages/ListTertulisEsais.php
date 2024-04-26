<?php

namespace App\Filament\Resources\Asesmen\TertulisEsaiResource\Pages;

use App\Filament\Resources\Asesmen\TertulisEsaiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTertulisEsais extends ListRecords
{
    protected static string $resource = TertulisEsaiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
