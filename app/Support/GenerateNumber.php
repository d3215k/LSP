<?php

namespace App\Support;

use App\Models\Asesi;
use App\Models\Sertifikat;
use App\Settings\SertifikatSetting;

class GenerateNumber
{
    public static function registrasi($kompetensiKeahlianReg = 'TIK')
    {
        $sertifikat = new SertifikatSetting();

        $currentYear = date('Y');
        $lastRegistration = Asesi::whereYear('created_at', $currentYear)
            ->orderByDesc('created_at')
            ->first();

        $lastNumber = $lastRegistration ? intval(substr($lastRegistration->no_reg, -9, 4)) : 0;
        $nextNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);

        $registrationNumber = "{$kompetensiKeahlianReg}.{$sertifikat->kode}.{$nextNumber} {$currentYear}";

        return $registrationNumber;
    }

    public static function sertifikat($kode_sertifikat_kompetensi_keahlian = '')
    {
        $currentYear = date('Y');
        $lastSertifikat = Sertifikat::whereYear('created_at', $currentYear)
            ->orderByDesc('created_at')
            ->first();

        $lastNumber = $lastSertifikat ? intval(substr($lastSertifikat->no_sertifikat, -12, 7)) : 0;
        $nextNumber = str_pad($lastNumber + 1, 7, '0', STR_PAD_LEFT);

        $number = "{$kode_sertifikat_kompetensi_keahlian} {$nextNumber} {$currentYear}";

        return $number;
    }

}
