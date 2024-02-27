<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum AsesmenStatus: int implements HasLabel, HasColor
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
            self::TERTULIS_ESAI => 'Pertanyaan Tertulis',
            self::SELESAI_KOMPETEN => 'Kompeten',
            self::SELESAI_BELUM_KOMPETEN => 'Belum Kompeten',
            self::SELESAI_BELUM_KOMPETEN_PERLU_TINDAK_LANJUT => 'Belum Kompeten, Perlu Tindak Lanjut',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            Self::DITOLAK => 'danger',
            self::REGISTRASI => 'info',
            self::ASESMEN_MANDIRI => 'primary',
            self::PERSETUJUAN => 'primary',
            self::OBSERVASI_AKTIVITAS => 'warning',
            self::OBSERVASI_PENDUKUNG => 'warning',
            self::TERTULIS_ESAI => 'warning',
            self::SELESAI_KOMPETEN => 'success',
            self::SELESAI_BELUM_KOMPETEN => 'danger',
            self::SELESAI_BELUM_KOMPETEN_PERLU_TINDAK_LANJUT => 'danger',
        };
    }
}
