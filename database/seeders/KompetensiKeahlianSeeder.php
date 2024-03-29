<?php

namespace Database\Seeders;

use App\Enums\SekolahType;
use App\Models\KompetensiKeahlian;
use App\Models\Sekolah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KompetensiKeahlianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ai = KompetensiKeahlian::create(['kode' => 'AGRIN', 'reg' => 'THP', 'sertifikat' => '10799 0751 2', 'nama' => 'Agroindustri']);
        $mm = KompetensiKeahlian::create(['kode' => 'MM', 'reg' => 'TIK', 'sertifikat' => '61929 2166 2', 'nama' => 'Multimedia']);
        $apat = KompetensiKeahlian::create(['kode' => 'APAT', 'reg' => 'PRK', 'sertifikat' => '03220 6221 2', 'nama' => 'Agribisnis Perikanan Air Tawar']);
        $atu = KompetensiKeahlian::create(['kode' => 'ATU', 'reg' => 'NAK', 'sertifikat' => '01460 5164 2', 'nama' => 'Agribisnis Ternak Unggas']);
        $atr = KompetensiKeahlian::create(['kode' => 'ATR', 'reg' => 'NAK', 'sertifikat' => '01410 5164 2', 'nama' => 'Agribisnis Ternak Ruminansia']);
        $atph = KompetensiKeahlian::create(['kode' => 'ATPH', 'reg' => 'TAN', 'sertifikat' => '01100 6111 2', 'nama' => 'Agribisnis Tanaman Pangan dan Hortikultura']);
        $aphp = KompetensiKeahlian::create(['kode' => 'APHP', 'reg' => 'THP', 'sertifikat' => '10799 7512 2', 'nama' => 'Agribisnis Pengolahan Hasil Pertanian']);
        $pmhp = KompetensiKeahlian::create(['kode' => 'PMHP', 'reg' => 'M', 'sertifikat' => '71202 3111 2', 'nama' => 'Pengawasan Mutu Hasil Pertanian']);

        $cibadak = Sekolah::create([
            'nama' => 'SMKN 1 Cibadak',
            'type' => SekolahType::SENDIRI,
        ]);

        $sagaranten = Sekolah::create([
            'nama' => 'SMKN 1 SAGARANTEN',
            'type' => SekolahType::JEJARING,
        ]);

        $cibadak->kompetensiKeahlian()->attach([$ai->id, $mm->id, $apat->id, $atu->id, $atr->id, $atph->id, $aphp->id, $pmhp->id]);
        $sagaranten->kompetensiKeahlian()->attach([$atph->id, $aphp->id, $pmhp->id]);
    }
}
