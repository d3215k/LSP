<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum JenisSkema: string implements HasLabel
{
    case OKUPASI = 'Okupasi';
    case KKNI = 'KKNI';
    case KLASTER = 'Klaster';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::OKUPASI => 'Okupasi',
            self::KKNI => 'KKNI',
            self::KLASTER => 'Klaster',
        };
    }
}
