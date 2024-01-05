<?php

use App\Models\Asesi;
use App\Models\Sertifikat;
use App\Settings\SertifikatSetting;
use Illuminate\Support\Facades\File;

if (!function_exists('generateNoReg')) {

    function generateNoReg($kompetensiKeahlianReg = 'TIK')
    {
        $sertifikat = new SertifikatSetting;

        $currentYear = date('Y');
        $lastRegistration = Asesi::whereYear('created_at', $currentYear)
            ->orderByDesc('created_at')
            ->first();

        $lastNumber = $lastRegistration ? intval(substr($lastRegistration->no_reg, -9, 4)) : 0;
        $nextNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);

        $registrationNumber = "{$kompetensiKeahlianReg}.{$sertifikat->kode}.{$nextNumber} {$currentYear}";

        return $registrationNumber;
    }

}

if (!function_exists('generateNoSertifikat')) {

    function generateNoSertifikat()
    {
        // TODO
        $sertifikat = new SertifikatSetting;
        return '71202 3111 2 0000001 2022';
    }

}

if (!function_exists('uploadSignature')) {

    function uploadSignature($directory = '', $signature, $name)
    {
        $folderPath = storage_path('app/public/'.$directory);

        if (!File::exists($folderPath)) {

            File::makeDirectory(path: $folderPath, recursive: true, force: true);

        }

        $image_parts = explode(";base64,", $signature);

        $image_type_aux = explode("image/", $image_parts[0]);

        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);

        $file = $folderPath . $name . '.'.$image_type;

        file_put_contents($file, $image_base64);

        return $directory.$name.'.'.$image_type;
    }
}
