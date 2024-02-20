<?php

namespace App\Filament\Imports\Skema;

use App\Models\Skema\KriteriaUnjukKerja;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class KriteriaUnjukKerjaImporter extends Importer
{
    protected static ?string $model = KriteriaUnjukKerja::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('elemen')
                ->requiredMapping()
                ->relationship()
                ->rules(['required']),
            ImportColumn::make('nama')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('sort')
                ->numeric()
                ->rules(['integer']),
        ];
    }

    public function resolveRecord(): ?KriteriaUnjukKerja
    {
        return new KriteriaUnjukKerja();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Kriteria unjuk kerja berhasil impor ' . number_format($import->successful_rows) . ' baris.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
