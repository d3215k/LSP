<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum JenisTempatUjiKompetensi: int implements HasLabel
{
    case SEWAKTU = 1;
    case TEMPAT_KERJA = 2;
    case MANDIRI = 3;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::SEWAKTU => 'Sewaktu',
            self::TEMPAT_KERJA => 'Tempat Kerja',
            self::MANDIRI => 'Mandiri',
        };
    }
}
