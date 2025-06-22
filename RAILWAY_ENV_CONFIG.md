# Railway Environment Variables Configuration

## Required Environment Variables for Railway Deployment

Set the following environment variables in your Railway project dashboard:

### Application Configuration
```
APP_NAME="Inventaris SMK Sasmita"
APP_ENV=production
APP_KEY=base64:l5V0+RSbo6bMBqXy8dzbWabLEzwR7G0kjlmq2hZ1eVA=
APP_DEBUG=false
APP_URL=https://Sistem-Inventaris.railway.app
```

### Database Configuration (MySQL)
```
DB_CONNECTION=mysql
DB_HOST=mysql.railway.internal
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=guBuUGOldryGWXYLYVeJyRsaeQasxlJw
```

### Cache and Session Configuration
```
CACHE_DRIVER=database
SESSION_DRIVER=database
SESSION_LIFETIME=120
```

### Nixpacks Configuration
```
NIXPACKS_PHP_ROOT_DIR=/app/public
```

### Additional Configuration
```
LOG_CHANNEL=stack
LOG_LEVEL=info
BROADCAST_DRIVER=log
QUEUE_CONNECTION=database
MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="Inventaris SMK Sasmita"
FILESYSTEM_DISK=public
```

## Railway Setup Instructions

1. **Create MySQL Service**: Add a new MySQL service in Railway
2. **Set Environment Variables**: Copy the above variables to your Railway project
3. **Deploy**: Railway will automatically deploy when you push to GitHub
4. **Monitor Logs**: Check Railway logs for any deployment issues

## Fixed Issues

### ✅ Procfile Syntax Error
- **Problem**: Conflict markers Git di Procfile menyebabkan error YAML
- **Solution**: Menghapus conflict markers dan menggunakan sintaks yang benar
- **Result**: Procfile sekarang valid dengan web dan release commands

### ✅ Package.json JSON Error  
- **Problem**: Conflict markers di package.json dan vite.config.js
- **Solution**: Memperbaiki sintaks JSON dan menghapus conflict markers
- **Result**: package.json valid dengan scripts dev dan build

### ✅ Routes API Syntax Error
- **Problem**: Conflict markers di routes/api.php baris 76
- **Solution**: Menghapus conflict markers dan menggunakan route yang benar
- **Result**: Route caching berhasil

### ✅ Source Root Issues
- **Problem**: Folder frontend/ dan Procfile_folder/ menyebabkan kebingungan
- **Solution**: Menghapus folder yang tidak diperlukan
- **Result**: Struktur proyek bersih dengan semua file penting di root

## Build Process

Railway akan menjalankan build process berikut:

1. **Setup Phase**: Install PHP 8.1, Node.js 18, npm, libmysqlclient
2. **Install Phase**: 
   - `composer install --ignore-platform-reqs --no-dev --optimize-autoloader`
   - `npm ci`
   - `npm run build`
3. **Build Phase**:
   - `php artisan config:cache`
   - `php artisan route:cache`
   - `php artisan view:cache`
   - `php artisan storage:link`
4. **Start Phase**: `php artisan serve --host=0.0.0.0 --port=$PORT`

## Troubleshooting

- If you get "Error: Reading Procfile", check for conflict markers (<<<<<<< HEAD, =======, >>>>>>>)
- If you get "source root is package" error, ensure no subfolders with package.json exist
- If you get JSON syntax errors, validate package.json with `node -e "require('./package.json')"`
- Make sure all required files are in the root directory
- Check that nixpacks.toml is properly configured
- Ensure routes/api.php has no syntax errors

## Current Status

✅ **Procfile**: Fixed and valid  
✅ **package.json**: Valid JSON syntax  
✅ **nixpacks.toml**: Properly configured  
✅ **routes/api.php**: No syntax errors  
✅ **Project Structure**: Clean root directory  
✅ **Build Process**: Tested locally  
✅ **Git Operations**: Committed and pushed  

**Ready for Railway deployment!** 🚀 