<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum AsesmenStatus: int implements HasLabel
{
    case DITOLAK = 0;
    case REGISTRASI = 1;
    case ASESMEN_MANDIRI = 2;
    case PERSETUJUAN = 3;
    case OBSERVASI_AKTIVITAS = 4;
    case OBSERVASI_PENDUKUNG = 5;
    case TERTULIS_ESAI = 6;

    case SELESAI_KOMPETEN = 11;
    case SELESAI_BELUM_KOMPETEN = 12;
    case SELESAI_BELUM_KOMPETEN_PERLU_TINDAK_LANJUT = 13;

    public function getLabel(): ?string
    {
        return match ($this) {
            Self::DITOLAK => 'Ditolak',
            self::REGISTRASI => 'Registrasi',
            self::ASESMEN_MANDIRI => 'Asesmen Mandiri',
            self::PERSETUJUAN => 'Diterima dan Dijadwalkan',
            self::OBSERVASI_AKTIVITAS => 'Observasi Aktivitas',
            self::OBSERVASI_PENDUKUNG => 'Pertanyaan Pendukung Observasi',
            self::TERTULIS_ESAI => 'Pertanyaan Tertulis Esai',
            self::SELESAI_KOMPETEN => 'Kompeten',
            self::SELESAI_BELUM_KOMPETEN => 'Belum Kompeten',
            self::SELESAI_BELUM_KOMPETEN_PERLU_TINDAK_LANJUT => 'Perlu Tindak Lanjut',
        };
    }
}
