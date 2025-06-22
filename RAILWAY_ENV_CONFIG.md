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

## Troubleshooting

- If you get "source root is package" error, ensure no subfolders with package.json exist
- If you get JSON syntax errors, validate package.json with `node -e "require('./package.json')"`
- Make sure all required files are in the root directory
- Check that nixpacks.toml is properly configured 