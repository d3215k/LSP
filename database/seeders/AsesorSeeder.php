<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\Asesor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AsesorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $asesor = Asesor::create([
            'email' => 'asesor@example.com',
            'nomor_registrasi' => '12345',
            'nama' => 'Asesor 1',
        ]);

        $asesor->user()->create([
            'name' => 'Asesor 1',
            'email' => 'asesor@example.com',
            'password' => bcrypt('password'),
            'type' => UserType::ASESOR,
        ]);
    }
}
