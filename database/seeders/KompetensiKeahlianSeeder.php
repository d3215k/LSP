<?php

namespace Database\Seeders;

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
        DB::table('kompetensi_keahlian')->insert([
            ['nama' => 'Agroindustri'],
            ['nama' => 'Multimedia'],
            ['nama' => 'Agribisnis Perikanan Air Tawar'],
            ['nama' => 'Agribisnis Ternak Unggas'],
            ['nama' => 'Agribisnis Ternak Ruminansia'],
            ['nama' => 'Agribisnis Tanaman Pangan dan Hortikultura'],
            ['nama' => 'Agribisnis Pengolahan Hasil Pertanian'],
            ['nama' => 'Pengawasan Mutu Hasil Pertanian'],
        ]);
    }
}
