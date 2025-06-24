# 🏫 Sistem Inventaris SMK SASMITA JAYA 2

[![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange.svg)](https://mysql.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC.svg)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

Sistem inventaris digital yang komprehensif untuk SMK SASMITA JAYA 2. Dibangun dengan Laravel 12, menggunakan Blade templates dan Tailwind CSS untuk antarmuka yang modern dan responsif.

## 📋 Daftar Isi

- [Fitur Utama](#-fitur-utama)
- [Teknologi yang Digunakan](#-teknologi-yang-digunakan)
- [Persyaratan Sistem](#-persyaratan-sistem)
- [Instalasi](#-instalasi)
- [Konfigurasi](#-konfigurasi)
- [Data Sample](#-data-sample)
- [Penggunaan](#-penggunaan)
- [Struktur Proyek](#-struktur-proyek)
- [API Documentation](#-api-documentation)
- [Testing](#-testing)
- [Deployment](#-deployment)
- [Kontribusi](#-kontribusi)
- [Lisensi](#-lisensi)

## ✨ Fitur Utama

### 🔐 Manajemen Pengguna & Keamanan
- **Sistem Autentikasi** dengan Laravel Sanctum
- **Role-Based Access Control** (Admin, Operator, Viewer)
- **Audit Trail** untuk semua aktivitas pengguna
- **Profil Pengguna** dengan manajemen data pribadi

### 📦 Manajemen Inventaris
- **CRUD Barang** dengan kategori dan sub-kategori
- **Upload Foto** untuk setiap barang
- **Tracking Kondisi** (Baik, Kurang Baik, Rusak)
- **Manajemen Lokasi** dan jumlah barang
- **Riwayat Perubahan** barang yang detail

### 📚 Manajemen Perpustakaan
- **Inventaris Buku** dengan sub-kategori khusus
- **Kategorisasi Buku** (Fiksi, Non-Fiksi, Referensi, dll.)
- **Status Buku** (Tersedia, Dipinjam, Maintenance)

### 🔄 Sistem Peminjaman
- **Proses Peminjaman Digital** dengan validasi
- **Tracking Status** (Aktif, Selesai, Terlambat)
- **Notifikasi Otomatis** untuk barang terlambat

## 🛠 Teknologi yang Digunakan

- **Backend:** Laravel 12.x
- **Frontend:** React.js + Inertia.js
- **Database:** MySQL 8.0+
- **Styling:** Tailwind CSS 3.x
- **Authentication:** Laravel Sanctum
- **PDF Generation:** DomPDF
- **Testing:** PHPUnit

## 💻 Persyaratan Sistem

- PHP >= 8.2
- Composer
- Node.js >= 16
- MySQL >= 8.0
- Git

## 🚀 Instalasi

1. Clone repository:
```bash
git clone https://github.com/yourusername/inventaris-smk-sasmita.git
cd inventaris-smk-sasmita
```

2. Install dependencies:
```bash
composer install
npm install
```

3. Setup environment:
```bash
cp .env.example .env
php artisan key:generate
```

4. Setup database:
```bash
php artisan migrate --seed
```

5. Build assets:
```bash
npm run build
```

6. Start server:
```bash
php artisan serve
```

## ⚙️ Konfigurasi

1. Database di `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

2. Mail (opsional) untuk notifikasi:
```env
MAIL_MAILER=smtp
MAIL_HOST=your_mail_host
MAIL_PORT=587
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@example.com
```

## 📊 Data Sample

Jalankan seeder untuk data sample:
```bash
php artisan db:seed
```

Default admin login:
- Email: admin@admin.com
- Password: password

## 🔍 Testing

Run tests with:
```bash
php artisan test
```

## 📝 Lisensi

Project ini dilisensikan di bawah [MIT License](LICENSE).

## 📞 Kontak

- **Email:** admin@smksasmita.sch.id
- **Website:** https://smksasmita.sch.id
- **Address:** Jl. Sasmita Jaya No. 123, Jakarta

## 🙏 Ucapan Terima Kasih

Terima kasih kepada semua kontributor dan pihak yang telah membantu dalam pengembangan sistem ini.

---

**Dibuat untuk SMK SASMITA JAYA 2**

# Railway Deployment Environment Setup

Tambahkan variabel berikut di Railway:

```
DB_CONNECTION=mysql
DB_HOST=${MYSQLHOST}
DB_PORT=${MYSQLPORT}
DB_DATABASE=${MYSQLDATABASE}
DB_USERNAME=${MYSQLUSER}
DB_PASSWORD=${MYSQLPASSWORD}
APP_URL=https://NAMA-RAILWAY-APP.up.railway.app
```

Jika MySQL Railway butuh SSL, tambahkan juga:
```
MYSQL_ATTR_SSL_CA=/etc/ssl/certs/ca-certificates.crt
```

Jika ingin retry koneksi database:
```
DB_RETRIES=3
DB_RETRY_AFTER=5
```

