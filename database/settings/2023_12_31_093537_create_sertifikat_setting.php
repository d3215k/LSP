<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('sertifikat.logo', '');
        $this->migrator->add('sertifikat.kode', '199');
        $this->migrator->add('sertifikat.nama_lembaga', 'Lembaga Sertifikasi Profesi SMK Negeri 1 Cibadak');
        $this->migrator->add('sertifikat.nama_lembaga_en', 'Professional Certification Body of Vocational High School 1 Cibadak');
        $this->migrator->add('sertifikat.ketua_lsp', 'Siti Maryam, S.Pt., M.P.');
        $this->migrator->add('sertifikat.ketua_bidang_sertifikasi', 'Wulan Handayani, S.Kom.');
        $this->migrator->add('sertifikat.masa_berlaku', '3 (tiga) Tahun');
        $this->migrator->add('sertifikat.masa_berlaku_en', '3 (three) Years');
        $this->migrator->add('sertifikat.tempat_terbit', 'Kab. Sukabumi');
    }
};
