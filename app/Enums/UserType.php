<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum UserType: int implements HasLabel, HasColor
{
    case ADMIN = 1;
    case ASESOR = 2;
    case ASESI = 3;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::ASESOR => 'Asesor',
            self::ASESI => 'Asesi',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::ADMIN => 'danger',
            self::ASESOR => 'success',
            self::ASESI => 'warning',
        };
    }
}
