<?php

namespace App\Filament\Resources\ElemenResource\Pages;

use App\Filament\Imports\Skema\ElemenImporter;
use App\Filament\Resources\ElemenResource;
use Filament\Actions;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListElemens extends ListRecords
{
    protected static string $resource = ElemenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
                ->importer(ElemenImporter::class)
        ];
    }
}
