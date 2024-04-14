<?php

namespace App\Filament\Resources\AsesmenResource\Pages;

use App\Filament\Exports\AsesmenExporter;
use App\Filament\Resources\AsesmenResource;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;

class ListAsesmens extends ListRecords
{
    protected static string $resource = AsesmenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->exporter(AsesmenExporter::class)
                ->label('Export Data Asesmen')
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            AsesmenResource\Widgets\AsesmenOverview::class,
        ];
    }

    public function mount(): void
    {
        parent::mount();
        if (!auth()->user()->isAdmin) {
            to_route('filament.app.pages.asesor.asesmen');
        }
    }
}
