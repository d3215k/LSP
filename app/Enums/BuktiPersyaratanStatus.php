<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum BuktiPersyaratanStatus: int implements HasLabel
{
    case ADA = 1;
    case MEMENUHI_SYARAT = 2;
    case TIDAK_MEMENUHI_SYARAT = 3;

    public function getLabel(): ?string
    {
        return match ($this) {
            Self::ADA => 'Ada',
            self::MEMENUHI_SYARAT => 'Memenuhi Syarat',
            self::TIDAK_MEMENUHI_SYARAT => 'Tidak Memenuhi Syarat',
        };
    }
}
