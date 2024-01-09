<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\Asesi;
use App\Support\GenerateNumber;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AsesiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $asesi1 = Asesi::create([
            'sekolah_id' => 1,
            'kompetensi_keahlian_id' => 1,
            'nama' => 'Asesi 1',
            'email' => 'asesi1@example.com',
            'no_reg' => GenerateNumber::registrasi('PRK')
        ]);

        $asesi1->user()->create([
            'name' => 'Asesi 1',
            'email' => 'asesi1@example.com',
            'password' => bcrypt('password'),
            'type' => UserType::ASESI,
        ]);

        sleep(1);

        $asesi2 = Asesi::create([
            'sekolah_id' => 2,
            'kompetensi_keahlian_id' => 1,
            'nama' => 'Asesi 2',
            'email' => 'asesi2@example.com',
            'no_reg' => GenerateNumber::registrasi('PRK')
        ]);

        $asesi2->user()->create([
            'name' => 'Asesi 2',
            'email' => 'asesi2@example.com',
            'password' => bcrypt('password'),
            'type' => UserType::ASESI,
        ]);
    }
}
