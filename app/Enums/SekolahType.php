<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum SekolahType: int implements HasLabel
{
    case SENDIRI = 1;
    case JEJARING = 2;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::SENDIRI => 'Sendiri',
            self::JEJARING => 'Jejaring',
        };
    }
}
