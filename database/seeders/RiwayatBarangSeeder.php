<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\RiwayatBarang;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RiwayatBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users and books
        $users = User::all();
        $books = Buku::all();
        
        if ($users->count() > 0 && $books->count() > 0) {
            // Create stock additions
            RiwayatBarang::factory()->count(20)->tambah()->create();
            
            // Create stock reductions
            RiwayatBarang::factory()->count(15)->kurang()->create();
            
            // Create stock adjustments
            RiwayatBarang::factory()->count(10)->penyesuaian()->create();
        }
    }
}
