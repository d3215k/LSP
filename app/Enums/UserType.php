<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum UserType: int implements HasLabel, HasColor
{
    case Admin = 1;
    case Asesor = 2;
    case Asesi = 3;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Admin => 'Admin',
            self::Asesor => 'Asesor',
            self::Asesi => 'Asesi',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Admin => 'danger',
            self::Asesor => 'success',
            self::Asesi => 'warning',
        };
    }
}
