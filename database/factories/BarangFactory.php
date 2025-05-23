<?php

namespace Database\Factories;

use App\Models\Kategori;
use App\Models\SubKategori;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang>
 */
class BarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $kategori = Kategori::inRandomOrder()->first() ?? Kategori::factory()->create();
        $subKategori = SubKategori::where('kategori_id', $kategori->id)
            ->inRandomOrder()
            ->first();
        
        return [
            'kode_barang' => strtoupper(substr($kategori->nama, 0, 3)) . fake()->unique()->numberBetween(1000, 9999),
            'nama_barang' => fake()->words(3, true),
            'deskripsi' => fake()->sentence(),
            'kategori_id' => $kategori->id,
            'sub_kategori_id' => $subKategori?->id,
            'kondisi' => fake()->randomElement(['baik', 'kurang_baik', 'rusak']),
            'status' => fake()->randomElement(['tersedia', 'dipinjam', 'maintenance']),
            'lokasi' => 'Lab ' . fake()->word(),
            'merek' => fake()->company(),
            'model' => fake()->bothify('??###'),
            'tahun_perolehan' => fake()->year(),
            'jumlah' => fake()->numberBetween(1, 20),
            'stok' => fake()->numberBetween(0, 10),
            'harga_perolehan' => fake()->numberBetween(100000, 5000000),
            'sumber_dana' => fake()->randomElement(['BOS', 'Dana Sekolah', 'Hibah']),
            'created_by' => User::factory(),
            'updated_by' => User::factory(),
        ];
    }
} 