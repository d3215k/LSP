<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\Asesi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AsesiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $asesi = Asesi::create([
            'kompetensi_keahlian_id' => 1,
            'nama' => 'Asesi 1',
        ]);

        $asesi->user()->create([
            'name' => 'Asesi 1',
            'email' => 'asesi@example.com',
            'password' => bcrypt('password'),
            'type' => UserType::ASESI,
        ]);
    }
}
