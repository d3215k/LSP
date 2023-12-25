<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum AsesmenStatus: int implements HasLabel
{
    case DITOLAK = 0;
    case REGISTRASI = 1;
    case ASESMEN_MANDIRI = 2;
    case DITERIMA = 3;
    case SELESAI_KOMPETEN = 4;
    case SELESAI_BELUM_KOMPETEN = 5;
    case SELESAI_BELUM_KOMPETEN_PERLU_TINDAK_LANJUT = 6;

    public function getLabel(): ?string
    {
        return match ($this) {
            Self::DITOLAK => 'Ditolak',
            self::REGISTRASI => 'Registrasi',
            self::ASESMEN_MANDIRI => 'Asesmen Mandiri',
            self::DITERIMA => 'Diterima dan Dijadwalkan',
            self::SELESAI_KOMPETEN => 'Kompeten',
            self::SELESAI_BELUM_KOMPETEN => 'Belum Kompeten',
            self::SELESAI_BELUM_KOMPETEN_PERLU_TINDAK_LANJUT => 'Perlu Tindak Lanjut',
        };
    }
}
