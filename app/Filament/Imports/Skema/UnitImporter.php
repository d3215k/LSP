<?php

namespace App\Filament\Imports\Skema;

use App\Models\Skema\Unit;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class UnitImporter extends Importer
{
    protected static ?string $model = Unit::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('skema')
                ->requiredMapping()
                ->relationship()
                ->rules(['required', 'integer']),
            ImportColumn::make('kode')
                ->requiredMapping()
                ->rules(['required', 'max:64']),
            ImportColumn::make('judul')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('judul_en')
                ->label('Judul (EN)')
                ->rules(['max:255']),
            ImportColumn::make('deskripsi')
                ->rules(['max:65535']),
            ImportColumn::make('sort')
                ->numeric()
                ->rules(['integer']),
        ];
    }

    public function resolveRecord(): ?Unit
    {
        return Unit::firstOrNew([
            'kode' => $this->data['kode'],
        ]);

    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Unit berhasil impor ' . number_format($import->successful_rows) . ' baris.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
