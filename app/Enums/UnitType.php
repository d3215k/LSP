<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum UnitType: int implements HasLabel
{
    case UMUM = 1;
    case PILIHAN = 2;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::UMUM => 'KOMPETENSI UMUM (GENERAL COMPETENCES)',
            self::PILIHAN => 'Jejaring',
        };
    }
}
