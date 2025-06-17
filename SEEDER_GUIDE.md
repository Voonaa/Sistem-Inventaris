# 📊 Panduan Penggunaan Seeder

Dokumen ini menjelaskan cara menggunakan seeder untuk mengisi database dengan data sample.

## 🗂️ File Seeder yang Tersedia

### 1. UserSeeder.php
- **Fungsi:** Membuat user admin default
- **Data yang dibuat:**
  - Email: `admin@admin.com`
  - Password: `password`
  - Role: `admin`

### 2. BarangSeeder.php
- **Fungsi:** Membuat data barang untuk semua kategori dan sub-kategori
- **Data yang dibuat:**
  - **Data Umum:** 5 barang (meja, kursi, lemari, dll.)
  - **Perpustakaan:** 45 barang (9 sub-kategori × 5 barang)
    - Barang Perpustakaan: 5 barang
    - Buku Umum: 5 barang
    - Cerita Pendek: 5 barang
    - Buku Teknik Instalasi: 5 barang
    - Buku Teknik Jaringan: 5 barang
    - Buku Teknik Mekatronika: 5 barang
    - Buku Teknik Otomotif: 5 barang
    - Buku Teknik Pendingin: 5 barang
    - Buku Teknik Elektronika: 5 barang
  - **Teknik Instalasi:** 5 barang
  - **Teknik Pemesinan:** 5 barang
  - **Teknik Otomotif:** 5 barang
  - **Teknik Sepeda Motor:** 5 barang
  - **Teknik Komputer:** 5 barang
  - **Teknik Elektronika:** 5 barang
- **Total:** 85 barang

## 🚀 Cara Menjalankan Seeder

### 1. Jalankan Semua Seeder
```bash
php artisan db:seed
```

### 2. Jalankan Seeder Tertentu
```bash
# Hanya user
php artisan db:seed --class=UserSeeder

# Hanya barang
php artisan db:seed --class=BarangSeeder
```

### 3. Reset Database dan Jalankan Seeder
```bash
php artisan migrate:fresh --seed
```

## 📋 Struktur Data yang Dibuat

### Kode Barang
- **Format:** `[KATEGORI][SUB_KATEGORI][NOMOR]`
- **Contoh:**
  - `DAT001` (Data Umum #1)
  - `PERBA001` (Perpustakaan Barang Perpustakaan #1)
  - `PERBU001` (Perpustakaan Buku Umum #1)
  - `INS001` (Instalasi #1)

### Kondisi Barang
- **Baik:** 33% chance
- **Kurang Baik:** 33% chance
- **Rusak:** 33% chance

### Lokasi Barang
- Gudang A
- Gudang B
- Lab Komputer
- Lab Otomotif
- Perpustakaan
- Ruang Guru

### Field Barang yang Diisi
- `kode_barang` - Kode unik barang
- `nama_barang` - Nama barang
- `deskripsi` - Deskripsi barang
- `kategori` - Kategori barang
- `sub_kategori` - Sub kategori (untuk perpustakaan)
- `kondisi` - Kondisi barang (baik/kurang_baik/rusak)
- `status` - Status barang (tersedia/dipinjam/maintenance)
- `lokasi` - Lokasi penyimpanan
- `jumlah` - Jumlah barang
- `created_by` - ID user yang membuat
- `updated_by` - ID user yang terakhir update

## 🔧 Kustomisasi Data

### Mengubah Jumlah Data
Edit file seeder yang sesuai dan ubah:
- Array nama barang di `BarangSeeder.php`

### Mengubah Lokasi
Edit array `$lokasiOptions` di `BarangSeeder.php` (baris 125)

## ⚠️ Catatan Penting

1. **Urutan Seeder:** User → Barang
2. **Dependencies:** Barang membutuhkan User untuk created_by
3. **User ID:** Semua data barang menggunakan admin user sebagai created_by
4. **Random Data:** Setiap kali dijalankan akan menghasilkan data yang berbeda
5. **Field Stok:** Field stok telah dihapus dari database, hanya menggunakan field jumlah

## 🎯 Hasil Akhir

Setelah menjalankan semua seeder, Anda akan memiliki:
- ✅ 1 user admin
- ✅ 85 barang dengan kategori lengkap
- ✅ Data siap untuk testing dan demo

## 🔄 Reset Data

Jika ingin menghapus semua data dan mulai dari awal:
```bash
php artisan migrate:fresh --seed
```

**Perhatian:** Perintah ini akan menghapus semua data di database! 