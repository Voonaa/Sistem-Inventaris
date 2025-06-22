# 🏫 Sistem Inventaris SMK Sasmita Jaya 2

[![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange.svg)](https://mysql.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC.svg)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

Sistem inventaris digital yang komprehensif untuk SMK Sasmita Jaya 2. Dibangun dengan Laravel 12, menggunakan Blade templates dan Tailwind CSS untuk antarmuka yang modern dan responsif.

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
- **Riwayat Peminjaman** per pengguna

### 📊 Pelaporan & Analitik
- **Dashboard Real-time** dengan statistik
- **Laporan Inventaris** dalam berbagai format
- **Laporan Peminjaman** dan pengembalian
- **Export Data** (PDF, Excel, CSV)
- **Grafik dan Visualisasi** data

### 🔍 Pencarian & Filter
- **Pencarian Real-time** dengan JavaScript
- **Filter berdasarkan Kategori** dan sub-kategori
- **Sorting** berdasarkan berbagai kriteria
- **Pagination** untuk performa optimal

## 🛠 Teknologi yang Digunakan

### Backend
- **Laravel 12** - PHP Framework
- **MySQL 8.0+** - Database Management System
- **Laravel Sanctum** - API Authentication
- **Laravel DomPDF** - PDF Generation
- **PhpSpreadsheet** - Excel/CSV Export

### Frontend
- **Blade Templates** - Laravel Templating Engine
- **Tailwind CSS 3.x** - Utility-First CSS Framework
- **Alpine.js** - Lightweight JavaScript Framework
- **Vite** - Build Tool & Development Server

### Development Tools
- **Composer** - PHP Dependency Manager
- **NPM** - Node.js Package Manager
- **Git** - Version Control System
- **PHPUnit** - Testing Framework

## 💻 Persyaratan Sistem

### Server Requirements
- **PHP** >= 8.2
- **Composer** >= 2.0
- **MySQL** >= 8.0 atau **MariaDB** >= 10.5
- **Node.js** >= 16.0 dan **NPM** >= 8.0
- **Web Server** (Apache/Nginx)

### PHP Extensions
```bash
# Extensions yang diperlukan
- BCMath PHP Extension
- Ctype PHP Extension
- cURL PHP Extension
- DOM PHP Extension
- Fileinfo PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PCRE PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- GD PHP Extension (untuk image processing)
```

## 🚀 Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/Voonaa/inventaris-smk-sasmita.git
cd inventaris-smk-sasmita
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup
```bash
# Configure database in .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventaris_smk
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Run migrations
php artisan migrate

# Seed database with sample data
php artisan db:seed
```

### 5. Storage Setup
```bash
# Create storage link
php artisan storage:link
```

### 6. Build Assets
```bash
# Development
npm run dev

# Production
npm run build
```

### 7. Start Development Server
```bash
php artisan serve
```

Aplikasi akan tersedia di `http://localhost:8000`

## ⚙️ Konfigurasi

### Environment Variables
```env
APP_NAME="Inventaris SMK Sasmita"
APP_ENV=local
APP_KEY=base64:your-generated-key
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventaris_smk
DB_USERNAME=root
DB_PASSWORD=

# File upload settings
FILESYSTEM_DISK=public
MAX_FILE_SIZE=2048

# Mail settings (untuk notifikasi)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@smksasmita.sch.id"
MAIL_FROM_NAME="${APP_NAME}"
```

### Default Login Credentials
Setelah menjalankan seeder, gunakan kredensial berikut:

#### Admin User
- **Email:** admin@admin.com
- **Password:** password

## 📊 Data Sample

Sistem ini dilengkapi dengan data sample yang komprehensif untuk testing dan demo:

### 📦 Data Barang (85 items)
- **Data Umum:** 5 barang (meja, kursi, lemari, dll.)
- **Perpustakaan:** 45 barang (9 sub-kategori × 5 barang)
  - Barang Perpustakaan, Buku Umum, Cerita Pendek
  - Buku Teknik: Instalasi, Jaringan, Mekatronika, Otomotif, Pendingin, Elektronika
- **Teknik:** 35 barang (7 jurusan × 5 barang)
  - Instalasi, Pemesinan, Otomotif, Sepeda Motor, Komputer, Elektronika

### 🚀 Cara Menjalankan Data Sample
```bash
# Jalankan semua seeder
php artisan db:seed

# Atau reset database dan jalankan seeder
php artisan migrate:fresh --seed

# Jalankan seeder tertentu
php artisan db:seed --class=BarangSeeder
```

**📖 Lihat [SEEDER_GUIDE.md](SEEDER_GUIDE.md) untuk detail lengkap tentang data sample.**

## 📖 Penggunaan

### Dashboard
- **Statistik Real-time** - Total barang, kondisi, peminjaman aktif
- **Grafik Tren** - Penggunaan barang per bulan
- **Notifikasi** - Barang terlambat, maintenance

### Manajemen Barang
1. **Tambah Barang Baru**
   - Klik "Tambah Barang"
   - Isi form dengan data lengkap
   - Upload foto barang (opsional)
   - Pilih kategori dan sub-kategori

2. **Edit Barang**
   - Klik ikon edit pada baris barang
   - Update informasi yang diperlukan
   - Simpan perubahan

3. **Hapus Barang**
   - Klik ikon hapus pada baris barang
   - Konfirmasi penghapusan
   - Barang akan di-soft delete

### Sistem Peminjaman
1. **Buat Peminjaman**
   - Pilih barang yang akan dipinjam
   - Tentukan jumlah dan tanggal pengembalian
   - Isi data peminjam
   - Konfirmasi peminjaman

2. **Pengembalian**
   - Klik "Kembalikan" pada peminjaman aktif
   - Konfirmasi pengembalian
   - Sistem akan update stok otomatis

### Pelaporan
1. **Laporan Inventaris**
   - Pilih periode laporan
   - Filter berdasarkan kategori
   - Export dalam format PDF/Excel

2. **Laporan Peminjaman**
   - Lihat statistik peminjaman
   - Filter berdasarkan status
   - Export data untuk analisis

## 📁 Struktur Proyek

```
inventaris-smk-sasmita/
├── app/
│   ├── Http/Controllers/     # Controllers
│   ├── Models/              # Eloquent Models
│   └── Providers/           # Service Providers
├── database/
│   ├── migrations/          # Database Migrations
│   ├── seeders/            # Database Seeders
│   └── factories/          # Model Factories
├── resources/
│   ├── views/              # Blade Templates
│   ├── css/               # Stylesheets
│   └── js/                # JavaScript Files
├── routes/
│   ├── web.php            # Web Routes
│   └── api.php            # API Routes
├── storage/
│   └── app/public/        # File Uploads
└── tests/                 # Test Files
```

### Key Models
- **User** - Manajemen pengguna dan autentikasi
- **Barang** - Data inventaris barang
- **Peminjaman** - Data peminjaman dan pengembalian
- **RiwayatBarang** - Audit trail perubahan barang
- **Kategori** - Kategorisasi barang

## 🔌 API Documentation

### Authentication
```bash
# Login
POST /api/login
{
    "email": "user@example.com",
    "password": "password"
}

# Logout
POST /api/logout
Authorization: Bearer {token}
```

### Barang Endpoints
```bash
# Get all barang
GET /api/barang

# Get single barang
GET /api/barang/{id}

# Create barang
POST /api/barang
{
    "kode_barang": "BRG001",
    "nama_barang": "Laptop Asus",
    "kategori": "elektronik",
    "jumlah": 10
}

# Update barang
PUT /api/barang/{id}

# Delete barang
DELETE /api/barang/{id}
```

### Peminjaman Endpoints
```bash
# Get all peminjaman
GET /api/peminjaman

# Create peminjaman
POST /api/peminjaman
{
    "barang_id": 1,
    "jumlah": 2,
    "tanggal_pinjam": "2024-01-15",
    "tanggal_kembali": "2024-01-20"
}

# Return item
PATCH /api/peminjaman/{id}/return
```

## 🧪 Testing

### Run Tests
```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter BarangTest

# Run with coverage
php artisan test --coverage
```

### Test Categories
- **Unit Tests** - Testing individual components
- **Feature Tests** - Testing complete features
- **Integration Tests** - Testing API endpoints

## 🚀 Deployment

### Production Setup
```bash
# Install production dependencies
composer install --optimize-autoloader --no-dev

# Build assets for production
npm run build

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set proper permissions
chmod -R 755 storage bootstrap/cache
```

### Server Configuration
```nginx
# Nginx Configuration
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/inventaris-smk-sasmita/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## 🤝 Kontribusi

Kontribusi sangat dihargai! Berikut langkah-langkah untuk berkontribusi:

1. **Fork** repository ini
2. **Create** branch fitur baru (`git checkout -b feature/AmazingFeature`)
3. **Commit** perubahan (`git commit -m 'Add some AmazingFeature'`)
4. **Push** ke branch (`git push origin feature/AmazingFeature`)
5. **Open** Pull Request

### Coding Standards
- Ikuti PSR-12 coding standards
- Gunakan meaningful commit messages
- Tambahkan tests untuk fitur baru
- Update documentation jika diperlukan

## 📝 Changelog

### v1.0.0 (2024-01-15)
- ✅ Initial release
- ✅ Basic CRUD operations
- ✅ User authentication
- ✅ Peminjaman system
- ✅ Reporting features
- ✅ Sample data seeder

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

## 📞 Kontak

- **Email:** admin@smksasmita.sch.id
- **Website:** https://smksasmita.sch.id
- **Address:** Jl. Sasmita Jaya No. 123, Jakarta

## 🙏 Ucapan Terima Kasih

Terima kasih kepada semua kontributor dan pihak yang telah membantu dalam pengembangan sistem ini.

---

**Dibuat untuk SMK Sasmita Jaya 2**

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
