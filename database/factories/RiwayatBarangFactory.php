<?php

namespace Database\Factories;

use App\Models\Buku;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RiwayatBarang>
 */
class RiwayatBarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jenisAktivitas = fake()->randomElement(['tambah', 'kurang', 'penyesuaian']);
        $jumlah = ($jenisAktivitas === 'tambah') ? 
            fake()->numberBetween(1, 20) : 
            fake()->numberBetween(1, 5);
            
        $stokSebelum = fake()->numberBetween(10, 100);
        $stokSesudah = ($jenisAktivitas === 'tambah') ? 
            $stokSebelum + $jumlah : 
            (($jenisAktivitas === 'kurang') ? $stokSebelum - $jumlah : fake()->numberBetween(5, 120));
        
        return [
            'buku_id' => Buku::inRandomOrder()->first() ?? Buku::factory(),
            'jenis_aktivitas' => $jenisAktivitas,
            'jumlah' => $jumlah,
            'stok_sebelum' => $stokSebelum,
            'stok_sesudah' => $stokSesudah,
            'keterangan' => fake()->sentence(),
            'user_id' => User::inRandomOrder()->first() ?? User::factory(),
        ];
    }
    
    /**
     * Indicate that this is a stock addition.
     */
    public function tambah(): static
    {
        return $this->state(function (array $attributes) {
            $jumlah = fake()->numberBetween(1, 20);
            $stokSebelum = $attributes['stok_sebelum'] ?? fake()->numberBetween(10, 100);
            
            return [
                'jenis_aktivitas' => 'tambah',
                'jumlah' => $jumlah,
                'stok_sesudah' => $stokSebelum + $jumlah,
            ];
        });
    }
    
    /**
     * Indicate that this is a stock reduction.
     */
    public function kurang(): static
    {
        return $this->state(function (array $attributes) {
            $stokSebelum = $attributes['stok_sebelum'] ?? fake()->numberBetween(10, 100);
            $jumlah = fake()->numberBetween(1, min(5, $stokSebelum));
            
            return [
                'jenis_aktivitas' => 'kurang',
                'jumlah' => $jumlah,
                'stok_sesudah' => $stokSebelum - $jumlah,
            ];
        });
    }
    
    /**
     * Indicate that this is a stock adjustment.
     */
    public function penyesuaian(): static
    {
        return $this->state(function (array $attributes) {
            $stokSebelum = $attributes['stok_sebelum'] ?? fake()->numberBetween(10, 100);
            $stokSesudah = fake()->numberBetween(5, 120);
            $jumlah = abs($stokSesudah - $stokSebelum);
            
            return [
                'jenis_aktivitas' => 'penyesuaian',
                'jumlah' => $jumlah,
                'stok_sesudah' => $stokSesudah,
            ];
        });
    }
}
