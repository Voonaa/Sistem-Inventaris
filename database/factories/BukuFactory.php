<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Buku>
 */
class BukuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $stok = fake()->numberBetween(10, 100);
        $dipinjam = fake()->numberBetween(0, min(5, $stok));
        
        return [
            'judul' => fake()->sentence(3),
            'pengarang' => fake()->name(),
            'penerbit' => fake()->company(),
            'tahun_terbit' => fake()->year(),
            'isbn' => fake()->isbn13(),
            'jumlah_halaman' => fake()->numberBetween(50, 500),
            'deskripsi' => fake()->paragraph(),
            'kategori' => fake()->randomElement(['pelajaran', 'fiksi', 'non-fiksi', 'referensi', 'lainnya']),
            'lokasi_rak' => 'Rak ' . fake()->randomLetter() . fake()->numberBetween(1, 20),
            'stok' => $stok,
            'dipinjam' => $dipinjam,
        ];
    }
    
    /**
     * Indicate that the book is a textbook.
     */
    public function pelajaran(): static
    {
        return $this->state(fn (array $attributes) => [
            'kategori' => 'pelajaran',
        ]);
    }
    
    /**
     * Indicate that the book is fiction.
     */
    public function fiksi(): static
    {
        return $this->state(fn (array $attributes) => [
            'kategori' => 'fiksi',
        ]);
    }
    
    /**
     * Indicate that the book is non-fiction.
     */
    public function nonFiksi(): static
    {
        return $this->state(fn (array $attributes) => [
            'kategori' => 'non-fiksi',
        ]);
    }
}
