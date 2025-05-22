# Deployment Guide for Inventaris SMK Sasmita

This guide provides instructions for building and deploying the Inventaris SMK Sasmita application to a production environment.

## Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js and npm
- MySQL or compatible database
- Web server (Nginx or Apache)
- SSL certificate for production environment

## Building the Application

### 1. Build the Frontend

From the root of the project, navigate to the `inventaris-frontend` directory and build the React application:

```bash
cd inventaris-frontend
npm install
npm run build
```

This will create a production-ready build in the `dist` directory.

### 2. Prepare the Backend

In the root of the project:

```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Deployment Options

### Option 1: Manual Deployment

1. Copy all Laravel files to your server's web directory
2. Copy the built frontend files (`inventaris-frontend/dist/*`) to your server's public directory or configure your server to serve these files
3. Set up your database and run migrations:
   ```bash
   php artisan migrate --force
   ```
4. Configure your web server to point to the Laravel public directory
5. Set up proper permissions for storage and cache directories:
   ```bash
   chmod -R 775 storage bootstrap/cache
   chown -R www-data:www-data storage bootstrap/cache
   ```

### Option 2: Laravel Forge

Laravel Forge simplifies server management and deployment:

1. Connect your Git repository to Forge
2. Configure your server in the Forge dashboard
3. Set up the deployment script to include frontend building:
   ```bash
   cd /home/forge/your-site.com
   git pull origin main
   composer install --optimize-autoloader --no-dev
   
   # Build frontend
   cd inventaris-frontend
   npm install
   npm run build
   cp -r dist/* ../public/
   
   # Back to Laravel root
   cd ..
   php artisan migrate --force
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
4. Deploy your application through the Forge dashboard

### Option 3: Laravel Vapor

Laravel Vapor is a serverless deployment platform for Laravel:

1. Install the Vapor CLI:
   ```bash
   composer global require laravel/vapor-cli
   ```

2. Create a Vapor configuration (vapor.yml) in the root directory:
   ```yaml
   id: 1234
   name: inventaris-smk-sasmita
   environments:
       production:
           memory: 1024
           cli-memory: 512
           runtime: php-8.2
           build:
               - 'composer install --optimize-autoloader --no-dev'
               - 'cd inventaris-frontend && npm install && npm run build && cp -r dist/* ../public/'
           deploy:
               - 'php artisan migrate --force'
   ```

3. Deploy to Vapor:
   ```bash
   vapor deploy production
   ```

## Environment Configuration

Make sure to properly configure your `.env` file for production:

```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-production-domain.com

DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_PORT=3306
DB_DATABASE=your-db-name
DB_USERNAME=your-db-username
DB_PASSWORD=your-secure-password

SESSION_DRIVER=redis
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
REDIS_HOST=your-redis-host

# Set up mail configuration
MAIL_MAILER=smtp
MAIL_HOST=your-mail-host
MAIL_PORT=587
MAIL_USERNAME=your-mail-username
MAIL_PASSWORD=your-mail-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@your-domain.com
MAIL_FROM_NAME="${APP_NAME}"
```

## SSL Configuration

For secure HTTPS connections, make sure to configure SSL:

### Nginx Example

```nginx
server {
    listen 443 ssl;
    server_name your-domain.com;
    
    ssl_certificate /path/to/certificate.crt;
    ssl_certificate_key /path/to/private.key;
    
    root /path/to/your-app/public;
    
    index index.php index.html;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
    }
}
```

### Apache Example

```apache
<VirtualHost *:443>
    ServerName your-domain.com
    DocumentRoot /path/to/your-app/public
    
    SSLEngine on
    SSLCertificateFile /path/to/certificate.crt
    SSLCertificateKeyFile /path/to/private.key
    
    <Directory /path/to/your-app/public>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

## Maintenance and Updates

To update the application:

1. Put the application in maintenance mode:
   ```bash
   php artisan down
   ```

2. Pull the latest changes:
   ```bash
   git pull origin main
   ```

3. Update dependencies and rebuild:
   ```bash
   composer install --optimize-autoloader --no-dev
   cd inventaris-frontend && npm install && npm run build
   ```

4. Run migrations:
   ```bash
   php artisan migrate --force
   ```

5. Clear caches:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

6. Bring the application back online:
   ```bash
   php artisan up
   ```

## Troubleshooting

### Common Issues

1. **500 Server Error**
   - Check Laravel logs: `storage/logs/laravel.log`
   - Verify proper permissions on storage and cache directories
   - Make sure `.env` file exists and is properly configured

2. **Frontend Assets Not Loading**
   - Verify the correct path to built assets
   - Check for any CORS issues in browser console
   - Ensure that the web server is correctly configured to serve static files

3. **Database Connection Issues**
   - Verify database credentials in `.env`
   - Check database server is running and accessible
   - Make sure proper permissions are granted to the database user 