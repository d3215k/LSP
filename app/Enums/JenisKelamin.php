<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum JenisKelamin: string implements HasLabel
{
    case LAKI_LAKI = 'L';
    case PEREMPUAN = 'P';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::LAKI_LAKI => 'Laki-laki',
            self::PEREMPUAN => 'Perempuan',
        };
    }
}
