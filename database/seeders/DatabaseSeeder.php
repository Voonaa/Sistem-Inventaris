<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed users first
        $this->call([
            UserSeeder::class,
        ]);

        // Seed barang data
        $this->call([
            BarangSeeder::class,
        ]);
    }
} 