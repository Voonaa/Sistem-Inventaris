# Railway Environment Configuration Guide

## Latest Fixes Applied (June 23, 2025)

### Fixed Issues:
1. **"undefined variable 'npm'" error** - Removed `npm` from `nixPkgs` in `nixpacks.toml`
2. **"undefined variable 'nodejs18'" error** - Changed to `nodejs-18_x`
3. **Cache issues** - Added `NIXPACKS_VERSION = "2.0"` to force rebuild
4. **Procfile conflicts** - Removed Procfile, using only `railway.toml` and `nixpacks.toml`

### Current Configuration Files:

#### nixpacks.toml
```toml
[phases.setup]
nixPkgs = ["php81", "php81Packages.composer", "nodejs-18_x", "libmysqlclient"]

[phases.install]
cmds = [
    "composer install --ignore-platform-reqs --no-dev --optimize-autoloader",
    "npm ci",
    "npm run build"
]

[phases.build]
cmds = [
    "php artisan config:cache",
    "php artisan view:cache",
    "php artisan storage:link"
]

[start]
cmd = "php artisan serve --host=0.0.0.0 --port=$PORT"

[variables]
NIXPACKS_PHP_ROOT_DIR = "/app/public"
NIXPACKS_VERSION = "2.0"
```

#### railway.toml
```toml
[build]
builder = "nixpacks"

[deploy]
startCommand = "php artisan serve --host=0.0.0.0 --port=$PORT"
healthcheckPath = "/"
healthcheckTimeout = 100
restartPolicyType = "on_failure"
restartPolicyMaxRetries = 10
```

## Required Environment Variables

Set these variables in Railway Dashboard > Your Project > Variables:

### Application Configuration
```
APP_NAME="Inventaris SMK Sasmita"
APP_ENV=production
APP_KEY=base64:l5V0+RSbo6bMBqXy8dzbWabLEzwR7G0kjlmq2hZ1eVA=
APP_URL=https://Sistem-Inventaris.railway.app
APP_DEBUG=false
APP_LOG_LEVEL=error
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

### Cache & Session
```
CACHE_DRIVER=database
SESSION_DRIVER=database
QUEUE_CONNECTION=sync
```

### Nixpacks Configuration
```
NIXPACKS_PHP_ROOT_DIR=/app/public
NIXPACKS_VERSION=2.0
```

### Optional: Mail Configuration (if needed)
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## Build Process

The build process follows this sequence:

1. **Setup Phase**: Install PHP 8.1, Composer, Node.js 18, MySQL client
2. **Install Phase**: 
   - Install Composer dependencies (production only)
   - Install npm dependencies
   - Build frontend assets
3. **Build Phase**:
   - Cache Laravel configuration
   - Cache Laravel views
   - Create storage symlink
4. **Start Phase**: Run Laravel development server

## Troubleshooting

### Common Issues:

1. **"undefined variable 'npm'"**
   - Solution: npm is included in nodejs-18_x, don't add it separately

2. **"undefined variable 'nodejs18'"**
   - Solution: Use `nodejs-18_x` instead of `nodejs18`

3. **Build cache issues**
   - Solution: Update `NIXPACKS_VERSION` to force rebuild

4. **Database connection issues**
   - Ensure MySQL service is running
   - Check DB_HOST is correct (mysql.railway.internal)
   - Verify credentials

5. **Storage permission issues**
   - The build process runs `php artisan storage:link`
   - Ensure storage directory is writable

### Debug Commands:

If you need to debug locally:
```bash
# Test composer install
composer install --ignore-platform-reqs --no-dev --optimize-autoloader

# Test npm build (after npm install)
npm run build

# Test Laravel commands
php artisan config:cache
php artisan view:cache
php artisan storage:link

# Test database connection
php artisan migrate:status
```

## Deployment Checklist

Before deploying:
- [ ] All environment variables are set in Railway
- [ ] MySQL service is provisioned and running
- [ ] nixpacks.toml is in root directory
- [ ] railway.toml is in root directory
- [ ] No Procfile exists (to avoid conflicts)
- [ ] package.json has valid JSON syntax
- [ ] composer.json has valid JSON syntax

## Monitoring Deployment

1. Go to Railway Dashboard > Your Project
2. Check the "Deployments" tab
3. Monitor build logs for any errors
4. Check application logs after deployment
5. Test the health check endpoint

## Post-Deployment

After successful deployment:
1. Run database migrations: `php artisan migrate`
2. Seed database if needed: `php artisan db:seed`
3. Test the application at your Railway URL
4. Monitor application logs for any runtime errors

## Support

If you encounter issues:
1. Check Railway build logs
2. Verify environment variables
3. Test locally with same configuration
4. Check Laravel logs in Railway dashboard 