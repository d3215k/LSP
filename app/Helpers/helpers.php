<?php

use Illuminate\Support\Facades\File;

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
