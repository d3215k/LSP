<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum TujuanAsesmen: int implements HasLabel
{
    case SERTIFIKASI = 1;
    case SERTIFIKASI_ULANG = 2;
    case PENGAKUAN_KOMPETENSI_TERKINI = 3;
    case REKOGNISI_PEMBELAJARAN_LAMPAU = 4;
    case LAINNYA = 5;

    public function getLabel(): ?string
    {
        return match ($this) {
            Self::SERTIFIKASI => 'Sertifikasi',
            self::SERTIFIKASI_ULANG => 'Sertifikasi Ulang',
            self::PENGAKUAN_KOMPETENSI_TERKINI => 'Pengakuan Kompetensi Terkini (PKT)',
            self::REKOGNISI_PEMBELAJARAN_LAMPAU => 'Rekognisi Pembelajaran Lampau',
            self::LAINNYA => 'Lainnya',
        };
    }
}
