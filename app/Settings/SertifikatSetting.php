<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SertifikatSetting extends Settings
{
    public string $logo;
    public string $kode;
    public string $nama_lembaga;
    public string $nama_lembaga_en;
    public string $ketua_lsp;
    public string $ketua_bidang_sertifikasi;
    public string $masa_berlaku;
    public string $masa_berlaku_en;

    public static function group(): string
    {
        return 'sertifikat';
    }
}
