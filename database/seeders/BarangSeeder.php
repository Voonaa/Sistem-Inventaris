<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user for created_by
        $adminUser = User::where('role', 'admin')->first();
        $userId = $adminUser ? $adminUser->id : 1;

        // Data Umum - 5 items
        $this->createBarangItems('data_umum', null, [
            'Meja Kerja Kayu Jati',
            'Kursi Plastik Standard',
            'Lemari Arsip 4 Pintu',
            'Papan Tulis Putih',
            'Rak Buku 5 Tingkat'
        ], $userId);

        // Perpustakaan - Barang Perpustakaan - 5 items
        $this->createBarangItems('perpustakaan', 'barang_perpustakaan', [
            'Scanner Barcode',
            'Printer Label',
            'Komputer Admin Perpustakaan',
            'Sistem Pencarian Digital',
            'Rak Buku Otomatis'
        ], $userId);

        // Perpustakaan - Buku Umum - 5 items
        $this->createBarangItems('perpustakaan', 'buku_umum', [
            'Ensiklopedia Indonesia',
            'Kamus Bahasa Inggris',
            'Atlas Dunia',
            'Buku Sejarah Nasional',
            'Panduan Belajar Matematika'
        ], $userId);

        // Perpustakaan - Cerita Pendek - 5 items
        $this->createBarangItems('perpustakaan', 'cerita_pendek', [
            'Kumpulan Cerpen Pilihan',
            'Cerita Rakyat Nusantara',
            'Antologi Cerpen Remaja',
            'Kumpulan Dongeng Anak',
            'Cerita Pendek Klasik'
        ], $userId);

        // Perpustakaan - Buku Teknik Instalasi - 5 items
        $this->createBarangItems('perpustakaan', 'instalasi', [
            'Panduan Instalasi Listrik Rumah',
            'Teknik Instalasi Penerangan',
            'Buku Instalasi Motor Listrik',
            'Panduan Instalasi Panel',
            'Teknik Instalasi Tenaga'
        ], $userId);

        // Perpustakaan - Buku Teknik Jaringan - 5 items
        $this->createBarangItems('perpustakaan', 'jaringan', [
            'Panduan Jaringan Komputer',
            'Teknik Konfigurasi Router',
            'Buku Jaringan Wireless',
            'Panduan Troubleshooting Jaringan',
            'Teknik Keamanan Jaringan'
        ], $userId);

        // Perpustakaan - Buku Teknik Mekatronika - 5 items
        $this->createBarangItems('perpustakaan', 'mekatronika', [
            'Dasar-dasar Mekatronika',
            'Panduan PLC Programming',
            'Buku Sistem Kontrol',
            'Teknik Robotika Dasar',
            'Panduan Sensor dan Aktuator'
        ], $userId);

        // Perpustakaan - Buku Teknik Otomotif - 5 items
        $this->createBarangItems('perpustakaan', 'otomotif', [
            'Panduan Mesin Mobil',
            'Teknik Sistem Bahan Bakar',
            'Buku Sistem Pengereman',
            'Panduan Transmisi Manual',
            'Teknik Kelistrikan Otomotif'
        ], $userId);

        // Perpustakaan - Buku Teknik Pendingin - 5 items
        $this->createBarangItems('perpustakaan', 'pendingin', [
            'Panduan AC Split',
            'Teknik Refrigerasi',
            'Buku Sistem Pendingin',
            'Panduan Troubleshooting AC',
            'Teknik Instalasi Pendingin'
        ], $userId);

        // Perpustakaan - Buku Teknik Elektronika - 5 items
        $this->createBarangItems('perpustakaan', 'elektronika', [
            'Dasar-dasar Elektronika',
            'Panduan Rangkaian Digital',
            'Buku Mikrokontroler',
            'Teknik Audio Video',
            'Panduan Perbaikan Elektronik'
        ], $userId);

        // Teknik Instalasi - 5 items
        $this->createBarangItems('instalasi', null, [
            'Multimeter Digital',
            'Tang Crimping',
            'Kabel NYM 2x2.5',
            'Saklar Tunggal',
            'Stop Kontak Ganda'
        ], $userId);

        // Teknik Pemesinan - 5 items
        $this->createBarangItems('pemesinan', null, [
            'Mesin Bubut Mini',
            'Pahat Bubut HSS',
            'Jangka Sorong Digital',
            'Mesin Bor Duduk',
            'Ragum Mesin'
        ], $userId);

        // Teknik Otomotif - 5 items
        $this->createBarangItems('otomotif', null, [
            'Scanner OBD2',
            'Kunci Pas Set',
            'Dongkrak Hidrolik',
            'Kompresor Angin',
            'Timing Light'
        ], $userId);

        // Teknik Sepeda Motor - 5 items
        $this->createBarangItems('sepeda_motor', null, [
            'Scanner Motor',
            'Kunci L 10mm',
            'Dongkrak Motor',
            'Kompresor Mini',
            'Timing Belt Tool'
        ], $userId);

        // Teknik Komputer - 5 items
        $this->createBarangItems('komputer', null, [
            'Laptop Dell Inspiron',
            'Monitor LED 24"',
            'Keyboard Mechanical',
            'Mouse Gaming',
            'Headset USB'
        ], $userId);

        // Teknik Elektronika - 5 items
        $this->createBarangItems('elektronika', null, [
            'Oscilloscope Digital',
            'Power Supply DC',
            'Breadboard 830 Point',
            'Komponen Elektronik Set',
            'Soldering Iron'
        ], $userId);
    }

    /**
     * Create barang items for specific category and sub-category
     */
    private function createBarangItems($kategori, $subKategori, $namaBarangList, $userId)
    {
        $kondisiOptions = ['baik', 'kurang_baik', 'rusak'];
        $lokasiOptions = ['Gudang A', 'Gudang B', 'Lab Komputer', 'Lab Otomotif', 'Perpustakaan', 'Ruang Guru'];

        foreach ($namaBarangList as $index => $namaBarang) {
            $kodeBarang = $this->generateKodeBarang($kategori, $subKategori, $index + 1);
            $jumlah = rand(1, 10);
            $kondisi = $kondisiOptions[array_rand($kondisiOptions)];
            
            $deskripsi = 'Deskripsi untuk ' . $namaBarang . '.';
            if ($kondisi === 'kurang_baik') {
                $deskripsi .= ' Terdapat sedikit goresan atau fungsi yang kurang optimal.';
            } elseif ($kondisi === 'rusak') {
                $deskripsi .= ' Membutuhkan perbaikan serius atau tidak dapat digunakan.';
            }
            
            Barang::create([
                'kode_barang' => $kodeBarang,
                'nama_barang' => $namaBarang,
                'deskripsi' => $deskripsi,
                'kategori' => $kategori,
                'sub_kategori' => $subKategori,
                'kondisi' => $kondisi,
                'status' => 'tersedia',
                'lokasi' => $lokasiOptions[array_rand($lokasiOptions)],
                'jumlah' => $jumlah,
                'created_by' => $userId,
                'updated_by' => $userId,
            ]);
        }
    }

    /**
     * Generate unique kode barang
     */
    private function generateKodeBarang($kategori, $subKategori, $index)
    {
        $prefix = strtoupper(substr($kategori, 0, 3));
        
        if ($subKategori) {
            $subPrefix = strtoupper(substr($subKategori, 0, 2));
            return $prefix . $subPrefix . str_pad($index, 3, '0', STR_PAD_LEFT);
        }
        
        return $prefix . str_pad($index, 3, '0', STR_PAD_LEFT);
    }
} 