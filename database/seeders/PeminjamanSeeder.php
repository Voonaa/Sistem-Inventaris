<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Database\Seeder;

class PeminjamanSeeder extends Seeder
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
            // Create some active loans
            Peminjaman::factory()->count(15)->dipinjam()->create();
            
            // Create some returned loans
            Peminjaman::factory()->count(20)->dikembalikan()->create();
            
            // Create some overdue loans
            Peminjaman::factory()->count(10)->terlambat()->create();
        }
    }
}
