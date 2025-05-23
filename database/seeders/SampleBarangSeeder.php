<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SampleBarangSeeder extends Seeder
{
    public function run(): void
    {
        // Get admin user for created_by
        $admin = User::where('role', 'admin')->first();
        
        // Create or get categories
        $instalasi = Kategori::firstOrCreate(['nama' => 'Instalasi', 'kode' => 'INS']);
        $otomotif = Kategori::firstOrCreate(['nama' => 'Otomotif', 'kode' => 'OTO']);
        $komputer = Kategori::firstOrCreate(['nama' => 'Komputer', 'kode' => 'KOM']);
        $elektronika = Kategori::firstOrCreate(['nama' => 'Elektronika', 'kode' => 'ELK']);
        
        $barangs = [
            [
                'kode_barang' => 'INS001',
                'nama_barang' => 'Multimeter Digital',
                'deskripsi' => 'Alat ukur listrik digital',
                'kategori_id' => $instalasi->id,
                'kondisi' => 'baik',
                'status' => 'tersedia',
                'stok' => 5,
                'lokasi' => 'Lab Instalasi',
                'merek' => 'Fluke',
                'model' => 'F117',
                'tahun_perolehan' => 2023,
                'jumlah' => 5,
                'harga_perolehan' => 750000,
                'sumber_dana' => 'BOS',
            ],
            [
                'kode_barang' => 'OTO001',
                'nama_barang' => 'Scanner OBD',
                'deskripsi' => 'Scanner diagnostik mobil',
                'kategori_id' => $otomotif->id,
                'kondisi' => 'baik',
                'status' => 'tersedia',
                'stok' => 3,
                'lokasi' => 'Lab Otomotif',
                'merek' => 'Launch',
                'model' => 'X431',
                'tahun_perolehan' => 2023,
                'jumlah' => 3,
                'harga_perolehan' => 3500000,
                'sumber_dana' => 'BOS',
            ],
            [
                'kode_barang' => 'KOM001',
                'nama_barang' => 'Toolkit Jaringan',
                'deskripsi' => 'Set alat untuk instalasi jaringan',
                'kategori_id' => $komputer->id,
                'kondisi' => 'baik',
                'status' => 'tersedia',
                'stok' => 4,
                'lokasi' => 'Lab Komputer',
                'merek' => 'D-Link',
                'model' => 'NTK-100',
                'tahun_perolehan' => 2023,
                'jumlah' => 4,
                'harga_perolehan' => 850000,
                'sumber_dana' => 'BOS',
            ],
            [
                'kode_barang' => 'ELK001',
                'nama_barang' => 'Oscilloscope Digital',
                'deskripsi' => 'Oscilloscope digital 100MHz',
                'kategori_id' => $elektronika->id,
                'kondisi' => 'baik',
                'status' => 'tersedia',
                'stok' => 5,
                'lokasi' => 'Lab Elektronika',
                'merek' => 'Rigol',
                'model' => 'DS1054Z',
                'tahun_perolehan' => 2023,
                'jumlah' => 5,
                'harga_perolehan' => 7500000,
                'sumber_dana' => 'BOS',
            ],
        ];

        foreach ($barangs as $barang) {
            $barang['created_by'] = $admin->id;
            $barang['updated_by'] = $admin->id;
            Barang::create($barang);
        }
    }
} 