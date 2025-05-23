<?php

namespace Database\Factories;

use App\Models\Barang;
use App\Models\Buku;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Peminjaman>
 */
class PeminjamanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tanggalPinjam = fake()->dateTimeBetween('-60 days', '-10 days');
        $tanggalKembali = date('Y-m-d', strtotime('+14 days', $tanggalPinjam->getTimestamp()));
        
        // Random chance to set the transaction as returned
        $status = fake()->randomElement(['dipinjam', 'dikembalikan']);
        $tanggalDikembalikan = null;
        
        if ($status === 'dikembalikan') {
            $tanggalDikembalikan = fake()->dateTimeBetween($tanggalPinjam, $tanggalKembali);
        } elseif (strtotime($tanggalKembali) < time()) {
            $status = 'terlambat';
        }

        // Randomly choose between barang and buku
        $isPerpustakaan = fake()->boolean();
        
        return [
            'user_id' => User::inRandomOrder()->first() ?? User::factory(),
            'barang_id' => $isPerpustakaan ? null : (Barang::inRandomOrder()->first() ?? Barang::factory()),
            'buku_id' => $isPerpustakaan ? (Buku::inRandomOrder()->first() ?? Buku::factory()) : null,
            'tanggal_pinjam' => $tanggalPinjam,
            'tanggal_kembali' => $tanggalKembali,
            'tanggal_dikembalikan' => $tanggalDikembalikan,
            'status' => $status,
            'catatan' => fake()->optional(0.3)->sentence(),
            'denda' => $status === 'terlambat' ? fake()->numberBetween(1000, 50000) : 0,
            'jumlah' => fake()->numberBetween(1, 3),
        ];
    }
    
    /**
     * Indicate that the peminjaman is currently borrowed.
     */
    public function dipinjam(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'dipinjam',
            'tanggal_dikembalikan' => null,
            'denda' => 0,
        ]);
    }
    
    /**
     * Indicate that the peminjaman is returned.
     */
    public function dikembalikan(): static
    {
        return $this->state(function (array $attributes) {
            $tanggalPinjam = $attributes['tanggal_pinjam'] ?? fake()->dateTimeBetween('-60 days', '-10 days');
            $tanggalKembali = $attributes['tanggal_kembali'] ?? date('Y-m-d', strtotime('+14 days', is_string($tanggalPinjam) ? strtotime($tanggalPinjam) : $tanggalPinjam->getTimestamp()));
            
            return [
                'status' => 'dikembalikan',
                'tanggal_dikembalikan' => fake()->dateTimeBetween($tanggalPinjam, $tanggalKembali),
                'denda' => 0,
            ];
        });
    }
    
    /**
     * Indicate that the peminjaman is overdue.
     */
    public function terlambat(): static
    {
        return $this->state(function (array $attributes) {
            $tanggalPinjam = fake()->dateTimeBetween('-60 days', '-30 days');
            $tanggalKembali = date('Y-m-d', strtotime('+14 days', $tanggalPinjam->getTimestamp()));
            
            return [
                'tanggal_pinjam' => $tanggalPinjam,
                'tanggal_kembali' => $tanggalKembali,
                'tanggal_dikembalikan' => null,
                'status' => 'terlambat',
                'denda' => fake()->numberBetween(1000, 50000),
            ];
        });
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function barang()
    {
        return $this->state(function (array $attributes) {
            return [
                'barang_id' => Barang::factory(),
                'buku_id' => null,
            ];
        });
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function buku()
    {
        return $this->state(function (array $attributes) {
            return [
                'barang_id' => null,
                'buku_id' => Buku::factory(),
            ];
        });
    }
}
