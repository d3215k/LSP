<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.nama', 'LSP P-1 SMKN 1 Cibadak');
        $this->migrator->add('general.jenis', 'LSP Pihak Kesatu');
        $this->migrator->add('general.sub_jenis', 'LSP P1 SMK');
        $this->migrator->add('general.no_akta', '412.5/336.b/SMKN1-CADISDIKWILV/2019');
        $this->migrator->add('general.tanggal_berdiri', '14/01/2014');
        $this->migrator->add('general.no_sertifikat_lisensi', 'BNSP-LSP-199-ID');
        $this->migrator->add('general.no_sk_lsp_terakhir', 'KEP.0509/BNSP/III/2020');
        $this->migrator->add('general.berlaku_mulai', '06/03/2020');
        $this->migrator->add('general.expired', '06/03/2025');
        $this->migrator->add('general.provinsi', 'Jawa Barat');
        $this->migrator->add('general.kota_kabupaten', 'Sukabumi');
        $this->migrator->add('general.alamat', 'Jalan Al Muwahidin Karang Tengah PO BOX 3 Cibadak 43351');
        $this->migrator->add('general.koordinat_lokasi', '-6.894077814102148,106.8159720062124');
        $this->migrator->add('general.no_telepon_kantor', '(0266) 532510');
        $this->migrator->add('general.no_handphone_admin', '081546995547');
        $this->migrator->add('general.email', 'lspp1smkn1cibadak@gmail.com');
        $this->migrator->add('general.website', '');
    }
};
