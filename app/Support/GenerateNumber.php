<?php

namespace App\Support;

use App\Enums\SequenceType;
use App\Models\Sequence;
use App\Settings\SertifikatSetting;

class GenerateNumber
{
    public static function registrasi($kompetensiKeahlianReg = 'TIK')
    {
        $sertifikat = new SertifikatSetting();

        $currentYear = date('Y');

        $seq = Sequence::firstOrCreate([
            'type' => SequenceType::REGISTRASI,
            'fy' => $currentYear,
        ]);

        $seq->increment('current');

        $nextNumber = str_pad($seq->current, 5, '0', STR_PAD_LEFT);

        $registrationNumber = "{$kompetensiKeahlianReg}.{$sertifikat->kode}.{$nextNumber} {$currentYear}";

        return $registrationNumber;
    }

    public static function sertifikat($kode_sertifikat_kompetensi_keahlian = '')
    {
        $currentYear = date('Y');

        $seq = Sequence::firstOrCreate([
            'type' => SequenceType::SERTIFIKAT,
            'fy' => $currentYear,
        ]);

        $seq->increment('current');

        $nextNumber = str_pad($seq->current, 5, '0', STR_PAD_LEFT);

        $number = "{$kode_sertifikat_kompetensi_keahlian} {$nextNumber} {$currentYear}";

        return $number;
    }

}
