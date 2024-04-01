<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum AsesmenTertulisStatus: int implements HasLabel, HasColor
{
    case MULAI = 1;
    case SELESAI = 2;

    public function getLabel(): ?string
    {
        return match ($this) {
            Self::MULAI => 'Sedang Mengerjakan',
            Self::SELESAI => 'Selesai',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            Self::MULAI => 'warning',
            Self::SELESAI => 'success',
        };
    }
}
