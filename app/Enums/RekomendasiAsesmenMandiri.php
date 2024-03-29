<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum RekomendasiAsesmenMandiri: int implements HasLabel, HasColor
{
    case DILANJUTKAN = 1;
    case TIDAK_DILANJUTKAN = 2;

    public function getLabel(): ?string
    {
        return match ($this) {
            Self::DILANJUTKAN => 'Dilanjutkan',
            self::TIDAK_DILANJUTKAN => 'Tidak Dapat Dilanjutkan',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::DILANJUTKAN => 'success',
            self::TIDAK_DILANJUTKAN => 'danger',
        };
    }
}
