# cPanel Quick Reference Guide

## Common cPanel Paths

### Finding Your Home Directory
- Usually: `/home/username/` or `/home/cpanelusername/`
- Check in File Manager → Current Path shown at top
- Or check in cPanel → User Information

### Document Root Locations
- **Main domain**: `public_html/`
- **Subdomain**: `public_html/subdomain/` or `subdomain/`
- **Addon domain**: `public_html/addondomain/` or `addondomain/`

## File Structure Options

### Option 1: Standard Laravel Structure (Recommended)
```
/home/username/
├── public_html/          (Document root - public/ contents go here)
│   ├── index.php
│   ├── .htaccess
│   ├── images/
│   └── ...
└── laravel/              (Laravel root - optional, can be in parent)
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── storage/
    └── ...
```

**public/index.php paths**: `__DIR__.'/../vendor/autoload.php'`

### Option 2: Everything in public_html
```
/home/username/public_html/
├── app/
├── bootstrap/
├── config/
├── public/              (This becomes redundant)
│   └── index.php
├── index.php           (Move from public/)
├── .htaccess
└── ...
```

**public/index.php paths**: Keep as `__DIR__.'/../vendor/autoload.php'`

### Option 3: Laravel in Subdirectory
```
/home/username/public_html/
├── laravel/            (Laravel root)
│   ├── app/
│   ├── bootstrap/
│   └── ...
└── index.php           (From public/)
```

**Update public/index.php**:
```php
require __DIR__.'/../laravel/vendor/autoload.php';
$app = require_once __DIR__.'/../laravel/bootstrap/app.php';
```

## Database Connection Strings

### Common Host Formats
- `localhost` (most common)
- `127.0.0.1`
- `mysql.yourhost.com`
- `yourhost.com` (sometimes)

**Check in cPanel → MySQL Databases → Current Host**

## PHP Version & Extensions

### Check PHP Version
- cPanel → **Select PHP Version** or **MultiPHP Manager**
- Required: PHP 8.2 or higher

### Required Extensions (Enable in cPanel)
- `php-mbstring`
- `php-xml`
- `php-curl`
- `php-zip`
- `php-gd`
- `php-mysql` or `php-mysqli`
- `php-openssl`
- `php-pdo`
- `php-tokenizer`
- `php-json`
- `php-fileinfo`

## Cron Job Examples

### Laravel Scheduler
```bash
* * * * * cd /home/username/public_html && php artisan schedule:run >> /dev/null 2>&1
```

### Queue Worker (if using queues)
```bash
* * * * * cd /home/username/public_html && php artisan queue:work --tries=3 >> /dev/null 2>&1
```

**Find your path**: File Manager → Navigate to Laravel root → Check "Current Path"

## Email Configuration

### SMTP Settings (usually)
- **Host**: `mail.stepstylebd.com` or `localhost`
- **Port**: `587` (TLS) or `465` (SSL) or `25`
- **Username**: `noreply@stepstylebd.com`
- **Password**: Email account password

**Create email in**: cPanel → Email Accounts

## Common Error Solutions

### "500 Internal Server Error"
1. Check file permissions (`storage/` = 775)
2. Check `.env` file exists
3. Check `APP_KEY` is set
4. Check error logs: `storage/logs/laravel.log`

### "Class not found" or "Composer autoload error"
- Run `composer install` on server (if SSH access)
- Or re-upload `vendor/` folder

### "Permission denied" on storage
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### "Route not found" (404)
- Check `.htaccess` exists in `public/`
- Check `mod_rewrite` is enabled
- Clear route cache: `php artisan route:clear`

### "Database connection refused"
- Check database host (try `localhost` and `127.0.0.1`)
- Verify database credentials
- Check database user has privileges

## File Permissions Reference

| File/Folder | Permission | Description |
|------------|------------|-------------|
| `storage/` | 775 | Must be writable |
| `bootstrap/cache/` | 775 | Must be writable |
| `public/` | 755 | Standard web directory |
| `.env` | 644 | Configuration file |
| `artisan` | 755 | Executable |

## Quick Commands (if SSH access)

```bash
# Navigate to Laravel root
cd /home/username/public_html

# Set permissions
chmod -R 775 storage bootstrap/cache

# Generate key
php artisan key:generate

# Run migrations
php artisan migrate --force

# Create storage link
php artisan storage:link

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Testing Checklist

After deployment, test:
- [ ] Homepage loads
- [ ] Product pages work
- [ ] Images display
- [ ] CSS/JS loads
- [ ] User registration
- [ ] User login
- [ ] Shopping cart
- [ ] Checkout process
- [ ] File uploads
- [ ] Email sending

## Support Contacts

- **Hosting Support**: Check your hosting provider's support
- **Laravel Docs**: https://laravel.com/docs
- **Error Logs**: `storage/logs/laravel.log`
- **cPanel Logs**: cPanel → Metrics → Errors

