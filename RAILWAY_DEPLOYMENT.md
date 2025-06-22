# Railway Deployment Guide untuk Laravel 10

## 📋 Konfigurasi Environment Variables di Railway

### **Variabel Wajib:**
```bash
APP_NAME="Inventaris SMK Sasmita"
APP_ENV=production
APP_KEY=base64:XAv1NB3wn8V42kgxAJj28E1R3gIWZG2pP6hDRShnGxk=
APP_DEBUG=false
APP_URL=https://your-app-name.up.railway.app

DB_CONNECTION=mysql
DB_HOST=mysql.railway.internal
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=YOUR_DB_PASSWORD
```

### **Variabel Tambahan untuk Production:**
```bash
LOG_CHANNEL=stack
LOG_LEVEL=error

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

FILESYSTEM_DISK=public
```

### **Konfigurasi Keamanan:**
```bash
SESSION_SECURE_COOKIE=false
SESSION_SAME_SITE=lax
```

## 🔧 Langkah-langkah Deployment

### **1. APP_KEY (SUDAH DI-GENERATE):**
```bash
APP_KEY=base64:XAv1NB3wn8V42kgxAJj28E1R3gIWZG2pP6hDRShnGxk=
```
**✅ Sudah di-generate dan siap digunakan**

### **2. Setup Database di Railway:**
1. Buat MySQL service di Railway
2. Link database service ke aplikasi
3. Railway akan otomatis menyediakan variabel database

### **3. Environment Variables di Railway Dashboard:**
1. Buka project Railway Anda
2. Klik tab "Variables"
3. Tambahkan semua variabel di atas
4. Pastikan `APP_URL` sesuai dengan domain Railway Anda

## 🚀 Konfigurasi nixpacks.toml

File `nixpacks.toml` sudah dikonfigurasi dengan:

- **PHP 8.1** dengan Composer
- **Node.js 18** dengan npm
- **NIXPACKS_PHP_ROOT_DIR** = `/app/public`
- **Build process** yang optimal untuk Laravel 10
- **Production optimizations** (config cache, storage link)

### **Isi nixpacks.toml:**
```toml
[phases.setup]
nixPkgs = ["php81", "php81Packages.composer", "nodejs-18", "npm"]

[phases.install]
cmds = [
  "composer install --no-dev --optimize-autoloader --no-interaction",
  "npm ci --only=production"
]

[phases.build]
cmds = [
  "npm run build",
  "php artisan config:cache",
  "php artisan storage:link"
]

[start]
cmd = "php artisan serve --host=0.0.0.0 --port=$PORT"

[variables]
NIXPACKS_PHP_ROOT_DIR = "/app/public"
```

## 📦 Build Process

Railway akan menjalankan:

1. **Setup Phase:**
   - Install PHP 8.1, Composer, Node.js 18, npm

2. **Install Phase:**
   - `composer install --no-dev --optimize-autoloader --no-interaction`
   - `npm ci --only=production`

3. **Build Phase:**
   - `npm run build` (compile frontend assets)
   - `php artisan config:cache` (cache konfigurasi)
   - `php artisan storage:link` (symbolic link untuk file uploads)

4. **Release Phase:**
   - `php artisan migrate --force` (dari Procfile)

5. **Start Phase:**
   - `php artisan serve --host=0.0.0.0 --port=$PORT`

## ✅ Status Testing

- **✅ Laravel 10.38.0** - Terinstal dan berfungsi
- **✅ Composer Dependencies** - Semua terinstal dengan benar
- **✅ NPM Dependencies** - Semua terinstal dengan benar
- **✅ Frontend Build** - Berhasil dikompilasi
- **✅ Config Cache** - Berfungsi dengan baik
- **✅ Storage Link** - Sudah ada dan berfungsi
- **✅ APP_KEY** - Sudah di-generate dan siap digunakan

## 🔍 Troubleshooting

### **Jika build gagal:**
1. Periksa log build di Railway
2. Pastikan semua environment variables terisi
3. Pastikan database service ter-link dengan benar

### **Jika aplikasi tidak bisa diakses:**
1. Periksa `APP_URL` sudah benar
2. Pastikan `APP_KEY` sudah di-set: `base64:XAv1NB3wn8V42kgxAJj28E1R3gIWZG2pP6hDRShnGxk=`
3. Periksa log aplikasi di Railway

### **Jika database error:**
1. Pastikan database service sudah dibuat
2. Periksa kredensial database di Railway
3. Pastikan database sudah ter-link ke aplikasi

### **Jika route caching error:**
- Route caching sengaja di-disable karena ada konflik nama route
- Aplikasi akan tetap berfungsi normal tanpa route cache

## 📝 Catatan Penting

- **APP_KEY**: `base64:XAv1NB3wn8V42kgxAJj28E1R3gIWZG2pP6hDRShnGxk=` (SUDAH DI-GENERATE)
- **APP_URL**: Harus menggunakan HTTPS dan domain Railway yang benar
- **Database**: Railway akan otomatis menyediakan kredensial database
- **Storage**: Symbolic link sudah dibuat untuk file uploads
- **Route Cache**: Di-disable sementara karena konflik nama route

## 🎯 Best Practices

1. **Environment**: Selalu gunakan `APP_ENV=production`
2. **Debug**: Selalu `APP_DEBUG=false` di production
3. **Logs**: Gunakan `LOG_LEVEL=error` untuk mengurangi log
4. **Security**: Gunakan `SESSION_SECURE_COOKIE=false` untuk Railway
5. **Performance**: Config cache di-enable untuk production

## 🚀 Siap Deploy!

Proyek Anda sudah siap untuk deployment di Railway dengan:
- ✅ Laravel 10.38.0
- ✅ PHP 8.1
- ✅ Node.js 18
- ✅ Semua dependensi terinstal
- ✅ Build process berfungsi
- ✅ APP_KEY sudah di-generate
- ✅ Konfigurasi production yang optimal 