<?php

namespace App\Filament\Resources\UnitResource\Pages;

use App\Filament\Imports\Skema\UnitImporter;
use App\Filament\Resources\UnitResource;
use Filament\Actions;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListUnits extends ListRecords
{
    protected static string $resource = UnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
                ->importer(UnitImporter::class)
        ];
    }
}
