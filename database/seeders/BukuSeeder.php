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
        // Create predefined books
        $books = [
            [
                'kode_barang' => 'BK-MTK-001',
                'judul' => 'Matematika Kelas X',
                'pengarang' => 'Tim Penyusun Kemendikbud',
                'penerbit' => 'Kemendikbud',
                'tahun_terbit' => 2020,
                'isbn' => '978-602-427-123-5',
                'jumlah_halaman' => 256,
                'deskripsi' => 'Buku pelajaran Matematika untuk kelas X SMA/SMK',
                'kategori' => 'pelajaran',
                'lokasi_rak' => 'Rak A1',
                'stok' => 25,
                'dipinjam' => 5,
                'kondisi' => 'baik',
                'status' => 'available',
                'tanggal_perolehan' => '2021-01-15',
                'sumber' => 'pembelian',
            ],
            [
                'kode_barang' => 'BK-IND-002',
                'judul' => 'Bahasa Indonesia Kelas XI',
                'pengarang' => 'Tim Penyusun Kemendikbud',
                'penerbit' => 'Kemendikbud',
                'tahun_terbit' => 2021,
                'isbn' => '978-602-427-456-7',
                'jumlah_halaman' => 220,
                'deskripsi' => 'Buku pelajaran Bahasa Indonesia untuk kelas XI SMA/SMK',
                'kategori' => 'pelajaran',
                'lokasi_rak' => 'Rak A2',
                'stok' => 30,
                'dipinjam' => 8,
                'kondisi' => 'baik',
                'status' => 'available',
                'tanggal_perolehan' => '2021-02-20',
                'sumber' => 'pembelian',
            ],
            [
                'kode_barang' => 'BK-FIK-003',
                'judul' => 'Laskar Pelangi',
                'pengarang' => 'Andrea Hirata',
                'penerbit' => 'Bentang Pustaka',
                'tahun_terbit' => 2005,
                'isbn' => '979-3062-79-7',
                'jumlah_halaman' => 529,
                'deskripsi' => 'Novel tentang perjuangan anak-anak Belitong untuk mendapatkan pendidikan',
                'kategori' => 'fiksi',
                'lokasi_rak' => 'Rak B3',
                'stok' => 15,
                'dipinjam' => 3,
                'kondisi' => 'baik',
                'status' => 'available',
                'tanggal_perolehan' => '2019-05-10',
                'sumber' => 'pembelian',
            ],
            [
                'kode_barang' => 'BK-NFK-004',
                'judul' => 'Filosofi Teras',
                'pengarang' => 'Henry Manampiring',
                'penerbit' => 'Kompas',
                'tahun_terbit' => 2018,
                'isbn' => '978-602-412-518-5',
                'jumlah_halaman' => 346,
                'deskripsi' => 'Buku tentang filsafat stoisisme dan aplikasinya dalam kehidupan sehari-hari',
                'kategori' => 'non-fiksi',
                'lokasi_rak' => 'Rak C1',
                'stok' => 10,
                'dipinjam' => 2,
                'kondisi' => 'baik',
                'status' => 'available',
                'tanggal_perolehan' => '2020-03-15',
                'sumber' => 'pembelian',
            ],
            [
                'kode_barang' => 'BK-REF-005',
                'judul' => 'Kamus Besar Bahasa Indonesia',
                'pengarang' => 'Pusat Bahasa',
                'penerbit' => 'Balai Pustaka',
                'tahun_terbit' => 2016,
                'isbn' => '978-979-461-984-5',
                'jumlah_halaman' => 1250,
                'deskripsi' => 'Kamus resmi Bahasa Indonesia',
                'kategori' => 'referensi',
                'lokasi_rak' => 'Rak D1',
                'stok' => 5,
                'dipinjam' => 0,
                'kondisi' => 'baik',
                'status' => 'available',
                'tanggal_perolehan' => '2018-01-05',
                'sumber' => 'pembelian',
            ],
        ];
        
        foreach ($books as $book) {
            Buku::create($book);
        }
        
        // Create additional random books
        Buku::factory()->count(15)->pelajaran()->create();
        Buku::factory()->count(10)->fiksi()->create();
        Buku::factory()->count(8)->nonFiksi()->create();
        Buku::factory()->count(12)->create(); // Random categories
    }
}
