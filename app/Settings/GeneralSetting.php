<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSetting extends Settings
{
    public string $nama;
    public string $jenis;
    public string $sub_jenis;
    public string $no_akta;
    public string $tanggal_berdiri;
    public string $no_sertifikat_lisensi;
    public string $no_sk_lsp_terakhir;
    public string $berlaku_mulai;
    public string $expired;
    public string $provinsi;
    public string $kota_kabupaten;
    public string $alamat;
    public string $koordinat_lokasi;
    public string $no_telepon_kantor;
    public string $no_handphone_admin;
    public string $email;
    public string $website;


    public static function group(): string
    {
        return 'general';
    }
}
