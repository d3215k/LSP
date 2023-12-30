<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum RekomendasiRekamanAsesmen: string implements HasLabel, HasColor
{
    case KOMPETEN = 'K';
    case BELUM_KOMPETEN = 'BK';

    public function getLabel(): ?string
    {
        return match ($this) {
            Self::KOMPETEN => 'Kompeten',
            self::BELUM_KOMPETEN => 'Belum Kompeten',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::KOMPETEN => 'success',
            self::BELUM_KOMPETEN => 'danger',
        };
    }
}
