<?php

namespace Database\Seeders;

use App\Enums\JenisSkema;
use App\Models\Periode;
use App\Models\Skema;
use App\Models\Skema\Elemen;
use App\Models\Skema\KriteriaUnjukKerja;
use App\Models\Skema\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skema = Skema::create([
            'mode' => 'Referensi BNSP',
            'nama' => 'SKEMA SERTIFIKASI KKNI LEVEL III PADA KOMPETENSI KEAHLIAN  AGROINDUSTRI',
            'jenis' => JenisSkema::KKNI,
            'kode' => 'SKM/BNSP/00003/1/2020/98',
            // 'tanggal_penetapan' => '',
            'no_urut' => 8,
            'no_penetapan' => 8,
            // 'biaya_asesmen' => ,
            'level_kkni' => 3,
            'sub_sektor' => 'Industri Pengolahan',
            'bidang' => 'Industri Makanan',
            'sub_bidang' => 'Industri Minyak dan Lemak Nabati dan Hewani',
            'sub_bidang_mea' => 'Produk Berbasis Agro',
            'kbji' => 'Pekerja Pengolahan, Kerajinan',
            'sub_kbji' => 'Pekerja Pengolahan Lainnya YTDL',
            'sub_bidang_kbji' => 'Pekerja Pengolahan Lainnya YTDL Lainnya',
            // 'cover' => '',
            // 'file' => 3,
        ]);

        Periode::create([
            'skema_id' => $skema->id,
            'nama' => 'Periode 1 2024',
            'buka' => today()->subDays(7),
            'tutup' => today()->addDays(7),
            'lokasi' => 'Cibadak',
        ]);

        $unit1 = Unit::create([
            'skema_id' => $skema->id,
            'kode' => 'S.1100000.018.01',
            'judul' => 'Judul Unit 1',
        ]);

        $unit2 = Unit::create([
            'skema_id' => $skema->id,
            'kode' => 'S.1100000.018.02',
            'judul' => 'Judul Unit 2',
        ]);

        $elemen1 = Elemen::create([
            'unit_id' => $unit1->id,
            'nama' => 'Elemen 1',
        ]);

        $elemen2 = Elemen::create([
            'unit_id' => $unit1->id,
            'nama' => 'Elemen 2',
        ]);

        $elemen3 = Elemen::create([
            'unit_id' => $unit2->id,
            'nama' => 'Elemen 3',
        ]);

        $elemen4 = Elemen::create([
            'unit_id' => $unit2->id,
            'nama' => 'Elemen 4',
        ]);

        $kuk1 = KriteriaUnjukKerja::create([
            'elemen_id' => $elemen1->id,
            'nama' => 'Kriteria Unjuk Kerja 1'
        ]);

        $kuk2 = KriteriaUnjukKerja::create([
            'elemen_id' => $elemen1->id,
            'nama' => 'Kriteria Unjuk Kerja 2'
        ]);

        $kuk3 = KriteriaUnjukKerja::create([
            'elemen_id' => $elemen2->id,
            'nama' => 'Kriteria Unjuk Kerja 3'
        ]);

        $kuk4 = KriteriaUnjukKerja::create([
            'elemen_id' => $elemen2->id,
            'nama' => 'Kriteria Unjuk Kerja 4'
        ]);

        $kuk5 = KriteriaUnjukKerja::create([
            'elemen_id' => $elemen3->id,
            'nama' => 'Kriteria Unjuk Kerja 5'
        ]);

        $kuk6 = KriteriaUnjukKerja::create([
            'elemen_id' => $elemen3->id,
            'nama' => 'Kriteria Unjuk Kerja 6'
        ]);

        $kuk7 = KriteriaUnjukKerja::create([
            'elemen_id' => $elemen4->id,
            'nama' => 'Kriteria Unjuk Kerja 7'
        ]);

        $kuk8 = KriteriaUnjukKerja::create([
            'elemen_id' => $elemen4->id,
            'nama' => 'Kriteria Unjuk Kerja 8'
        ]);
    }
}
