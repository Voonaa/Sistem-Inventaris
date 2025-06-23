#!/bin/sh

# Exit on error
set -e

echo "🚀 Starting build process..."

# Install Composer if not available
if ! [ -x "$(command -v composer)" ]; then
    echo "📥 Installing Composer..."
    EXPECTED_CHECKSUM="$(php -r 'copy("https://composer.github.io/installer.sig", "php://stdout");')"
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    ACTUAL_CHECKSUM="$(php -r "echo hash_file('sha384', 'composer-setup.php');")"

    if [ "$EXPECTED_CHECKSUM" != "$ACTUAL_CHECKSUM" ]; then
        >&2 echo 'ERROR: Invalid installer checksum'
        rm composer-setup.php
        exit 1
    fi

    php composer-setup.php --quiet
    rm composer-setup.php
    mv composer.phar /usr/local/bin/composer
fi

# Create necessary directories
echo "📁 Creating temporary directories..."
mkdir -p /tmp/storage/framework/{sessions,views,cache}
mkdir -p /tmp/storage/logs
mkdir -p bootstrap/cache

# Set up storage directory
echo "📂 Setting up storage directory..."
cp -r storage/app /tmp/storage/
cp -r storage/framework /tmp/storage/
chmod -R 777 /tmp/storage

# Install PHP dependencies
echo "📦 Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader

# Generate application key if not set
if [ -z "$APP_KEY" ]; then
    echo "🔑 Generating application key..."
    php artisan key:generate --force
fi

# Clear and cache configuration
echo "🧹 Clearing and caching configuration..."
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan route:cache
php artisan view:clear
php artisan view:cache

# Create SQLite database
echo "🗄️ Setting up database..."
mkdir -p /tmp
touch /tmp/database.sqlite
php artisan migrate --force

# Install and build frontend assets
echo "🎨 Building frontend assets..."
npm ci
npm run build

# Create storage symlink
echo "🔗 Creating storage link..."
php artisan storage:link

# Optimize
echo "⚡ Optimizing application..."
php artisan optimize

# Set proper permissions
echo "🔒 Setting permissions..."
chmod -R 777 /tmp
chmod -R 777 bootstrap/cache
chmod -R 777 storage

echo "✅ Build completed successfully!" 