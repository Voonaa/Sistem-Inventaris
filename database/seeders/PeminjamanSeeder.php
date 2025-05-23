<?php

namespace Database\Seeders;

use App\Models\Barang;
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
        // Get users, books, and barangs
        $users = User::all();
        $books = Buku::all();
        $barangs = Barang::all();
        
        if ($users->count() > 0) {
            // Create some active loans for barang
            Peminjaman::factory()->count(10)->barang()->dipinjam()->create();
            
            // Create some returned loans for barang
            Peminjaman::factory()->count(15)->barang()->dikembalikan()->create();
            
            // Create some overdue loans for barang
            Peminjaman::factory()->count(5)->barang()->terlambat()->create();

            if ($books->count() > 0) {
                // Create some active loans for books
                Peminjaman::factory()->count(5)->buku()->dipinjam()->create();
                
                // Create some returned loans for books
                Peminjaman::factory()->count(5)->buku()->dikembalikan()->create();
                
                // Create some overdue loans for books
                Peminjaman::factory()->count(5)->buku()->terlambat()->create();
            }
        }
    }
}
