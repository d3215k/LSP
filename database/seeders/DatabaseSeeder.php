<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\UserType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            KompetensiKeahlianSeeder::class,
            KomponenUmpanBalikSeeder::class,
            SkemaSeeder::class,
            AsesiSeeder::class,
            AsesorSeeder::class,
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Admin 1',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'type' => UserType::ADMIN
        ]);
    }
}
