<?php

namespace Database\Seeders;

use App\Models\Buku;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bukus = [
            [
                'kode_barang' => 'BK001',
                'judul' => 'Matematika Dasar',
                'pengarang' => 'Dr. Ahmad',
                'penerbit' => 'Gramedia',
                'tahun_terbit' => 2020,
                'isbn' => '9782912199034',
                'jumlah_halaman' => 200,
                'deskripsi' => 'Buku matematika untuk SMA',
                'kategori' => 'pelajaran',
                'lokasi_rak' => 'A1',
                'stok' => 5,
                'kondisi' => 'baik',
                'status' => 'available',
            ],
            [
                'kode_barang' => 'BK002',
                'judul' => 'Fisika Dasar',
                'pengarang' => 'Dr. Budi',
                'penerbit' => 'Erlangga',
                'tahun_terbit' => 2021,
                'isbn' => '9782912199035',
                'jumlah_halaman' => 250,
                'deskripsi' => 'Buku fisika untuk SMA',
                'kategori' => 'pelajaran',
                'lokasi_rak' => 'A2',
                'stok' => 3,
                'kondisi' => 'baik',
                'status' => 'available',
            ],
        ];

        foreach ($bukus as $buku) {
            Buku::create($buku);
        }
    }
}
