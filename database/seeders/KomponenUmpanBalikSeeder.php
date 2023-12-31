<?php

namespace Database\Seeders;

use App\Models\Asesmen\KomponenUmpanBalik;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KomponenUmpanBalikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KomponenUmpanBalik::insert([
            ['komponen' => 'Saya mendapatkan penjelasan yang cukup memadai mengenai proses asesmen/uji kompetensi'],
            ['komponen' => 'Saya diberikan kesempatan untuk mempelajari standar kompetensi yang akan diujikan dan menilai diri sendiri terhadap pencapaiannya'],
            ['komponen' => 'Asesor memberikan kesempatan untuk mendiskusikan/menegosiasikan metoda, instrumen dan sumber asesmen serta jadwal asesmen '],
            ['komponen' => 'Asesor berusaha menggali seluruh bukti pendukung yang sesuai dengan latar belakang pelatihan dan pengalaman yang saya miliki'],
            ['komponen' => 'Saya sepenuhnya diberikan kesempatan untuk mendemonstrasikan kompetensi yang saya miliki selama asesmen'],
            ['komponen' => 'Saya mendapatkan penjelasan yang memadai mengenai keputusan asesmen'],
            ['komponen' => 'Asesor memberikan umpan balik yang mendukung setelah asesmen serta tindak lanjutnya'],
            ['komponen' => 'Asesor bersama saya mempelajari semua dokumen asesmen serta menandatanganinya'],
            ['komponen' => 'Saya mendapatkan jaminan kerahasiaan hasil asesmen serta penjelasan penanganan dokumen asesmen'],
            ['komponen' => 'Asesor menggunakan keterampilan komunikasi yang efektif selama asesmen'],
        ]);
    }
}
