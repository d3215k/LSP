<?php

namespace Database\Seeders;

use App\Models\Skema;
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
            'jenis' => 'KKNI',
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

        $skema->unit()->createMany([
            [
                'kode' => 'C.10SRM00.008.1',
                'judul' => 'Membuat Surimi',
            ],
            [
                'kode' => 'C.110000.018.01',
                'judul' => 'Menganalisis Angka Lempeng Total (ALT)',
            ],
            [
                'kode' => 'M.749000.031.01',
                'judul' => 'Melaksanakan Analisis Fisiko-Kimia Mengikuti Prosedur',
            ],
            [
                'kode' => 'A.01TAN00.015.01',
                'judul' => 'Mengoperasikan Mesin Sangrai Kopi dan Kakao',
            ],
            [
                'kode' => 'THP.ID02.023.01',
                'judul' => 'Mengidentifikasi Bahan/Komoditas Hasil Ternak',
            ],
            [
                'kode' => 'THP.ID02.024.01',
                'judul' => 'Mengidentifikasi Bahan/Komoditas Ikan',
            ],
            [
                'kode' => 'THP.ID02.025.01',
                'judul' => 'Mengidentifikasi Bahan/Komoditas Hasil Samping',
            ],
            [
                'kode' => 'THP.OO01.003.01',
                'judul' => 'Mengidentifikasi Bahan/Komoditas Pertanian',
            ],
        ]);
    }
}
