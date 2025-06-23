#!/bin/bash

# Exit on error
set -e

echo "🚀 Starting build process..."

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
composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Install Node.js dependencies and build assets
echo "🔨 Installing Node.js dependencies and building assets..."
npm ci
npm run build

# Create SQLite database
echo "🗄️ Setting up database..."
touch /tmp/database.sqlite
chmod 777 /tmp/database.sqlite

# Clear and optimize Laravel
echo "🧹 Optimizing Laravel..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan optimize

# Run migrations
echo "🔄 Running database migrations..."
php artisan migrate --force --database=sqlite

# Set proper permissions
echo "🔒 Setting permissions..."
chmod -R 777 /tmp
chmod -R 777 bootstrap/cache
chmod -R 777 storage

echo "✅ Build process completed!" 