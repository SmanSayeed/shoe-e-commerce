# Laravel E-Commerce Deployment Guide for cPanel Shared Hosting
## Domain: stepstylebd.com

This guide will walk you through deploying your Laravel 12 e-commerce application to cPanel shared hosting step by step.

---

## 📋 Prerequisites Checklist

Before starting, ensure you have:
- ✅ cPanel access credentials
- ✅ FTP/SFTP access or File Manager access
- ✅ Database credentials from your hosting provider
- ✅ PHP version 8.2 or higher (check in cPanel)
- ✅ Composer installed locally (for building the project)
- ✅ Node.js and NPM installed locally (for building assets)

---

## 🚀 Step-by-Step Deployment Process

### **STEP 1: Prepare Your Local Project**

#### 1.1 Build Production Assets
```bash
# Navigate to your project directory
cd L:\laragon\www\shoe-ecommerce\saad\shoe-e-commerce

# Install dependencies (if not already done)
composer install --no-dev --optimize-autoloader
npm install
npm run build
```

#### 1.2 Optimize Laravel for Production
```bash
# Clear and cache configuration
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### 1.3 Create Deployment Package
Create a `.zip` file excluding unnecessary files:
- ✅ Include: `app/`, `bootstrap/`, `config/`, `database/`, `public/`, `resources/`, `routes/`, `storage/`, `vendor/`, `artisan`, `composer.json`, `composer.lock`
- ❌ Exclude: `node_modules/`, `.git/`, `tests/`, `.env`, `storage/logs/*`, `storage/framework/cache/*`, `storage/framework/sessions/*`, `storage/framework/views/*`

---

### **STEP 2: Access cPanel**

1. Log in to your cPanel: `https://stepstylebd.com:2083` (or your hosting provider's cPanel URL)
2. Navigate to **File Manager** or use an FTP client (FileZilla, WinSCP, etc.)

---

### **STEP 3: Upload Files to Server**

#### 3.1 Determine Your Document Root
- **Option A (Recommended)**: If your domain points directly to `public_html/`
  - Upload all Laravel files to `public_html/` EXCEPT the `public/` folder contents
  - Upload `public/` folder contents directly to `public_html/`

- **Option B**: If you have a subdomain or addon domain
  - Upload Laravel files to the domain's root directory
  - Upload `public/` contents to the document root

#### 3.2 Upload Structure
```
public_html/
├── app/
├── bootstrap/
├── config/
├── database/
├── resources/
├── routes/
├── storage/
├── vendor/
├── artisan
├── composer.json
├── composer.lock
└── [other Laravel files]

public_html/ (or document root)
├── index.php
├── .htaccess
├── favicon.ico
├── images/
├── js/
└── [other public files]
```

**Important**: The `public/` folder contents go to `public_html/`, and the rest of Laravel goes one level up or in a parent directory.

---

### **STEP 4: Configure File Permissions**

Set proper permissions via File Manager or SSH:

```bash
# Storage and cache directories (must be writable)
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# If you have SSH access, you can also run:
chown -R username:username storage bootstrap/cache
```

**Via cPanel File Manager:**
1. Right-click `storage/` folder → Change Permissions → Set to `775`
2. Right-click `bootstrap/cache/` folder → Change Permissions → Set to `775`
3. Ensure all subdirectories inside `storage/` have `775` permissions

---

### **STEP 5: Create and Configure Database**

#### 5.1 Create MySQL Database
1. In cPanel, go to **MySQL Databases**
2. Create a new database: `stepstyle_shoe` (or your preferred name)
3. Create a database user: `stepstyle_user` (or your preferred name)
4. Add user to database with **ALL PRIVILEGES**
5. Note down:
   - Database name: `stepstyle_shoe`
   - Database username: `stepstyle_user`
   - Database password: `[your_password]`
   - Database host: Usually `localhost` (check with your hosting provider)

#### 5.2 Import Database (if you have a backup)
1. Go to **phpMyAdmin** in cPanel
2. Select your database
3. Click **Import** → Choose your `.sql` file → **Go**

---

### **STEP 6: Configure Environment File**

#### 6.1 Create `.env` File
1. In File Manager, navigate to your Laravel root (where `artisan` is)
2. Create a new file named `.env`
3. Copy the content from `env-example.txt` and modify:

```env
APP_NAME="StepStyle BD"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_TIMEZONE=Asia/Dhaka
APP_URL=https://stepstylebd.com

APP_LOCALE=en
APP_FALLBACK_LOCALE=en

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=stepstyle_shoe
DB_USERNAME=stepstyle_user
DB_PASSWORD=your_database_password

SESSION_DRIVER=database
SESSION_LIFETIME=120

CACHE_STORE=database
QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=mail.stepstylebd.com
MAIL_PORT=587
MAIL_USERNAME=noreply@stepstylebd.com
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@stepstylebd.com
MAIL_FROM_NAME="${APP_NAME}"

# Disable Meilisearch for shared hosting (optional)
SCOUT_DRIVER=null

# Add your API keys for production
TWILIO_SID=your_twilio_sid
TWILIO_AUTH_TOKEN=your_twilio_token
TWILIO_PHONE_NUMBER=your_twilio_number
TWILIO_VERIFY_SID=your_verify_sid

STRIPE_KEY=your_stripe_key
STRIPE_SECRET=your_stripe_secret

PAYPAL_MODE=live
PAYPAL_CLIENT_ID=your_paypal_client_id
PAYPAL_CLIENT_SECRET=your_paypal_secret

# Other settings...
DEFAULT_CURRENCY=BDT
CURRENCY_SYMBOL=৳
```

#### 6.2 Generate Application Key
If you have SSH access:
```bash
cd /home/username/public_html  # or your Laravel root
php artisan key:generate
```

**If you don't have SSH access**, you can:
1. Generate key locally: `php artisan key:generate --show`
2. Copy the generated key and paste it in `.env` as `APP_KEY=base64:...`

---

### **STEP 7: Update Public/index.php (if needed)**

If your Laravel files are NOT in `public_html/` but in a parent directory, update `public/index.php`:

**Original:**
```php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
```

**If Laravel is in parent directory:**
```php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
```

**If Laravel is in a subdirectory (e.g., `laravel/`):**
```php
require __DIR__.'/../laravel/vendor/autoload.php';
$app = require_once __DIR__.'/../laravel/bootstrap/app.php';
```

---

### **STEP 8: Configure .htaccess Files**

#### 8.1 Root .htaccess (if Laravel is in subdirectory)
Create `.htaccess` in `public_html/`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

#### 8.2 Public .htaccess
Ensure `public/.htaccess` exists (it should already be there):

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

---

### **STEP 9: Run Migrations and Seeders**

If you have SSH access:
```bash
cd /home/username/public_html
php artisan migrate --force
php artisan db:seed --force
```

**If you don't have SSH access:**
1. Create a temporary route in `routes/web.php`:
```php
Route::get('/install', function() {
    Artisan::call('migrate', ['--force' => true]);
    Artisan::call('db:seed', ['--force' => true]);
    return 'Database migrated and seeded!';
});
```
2. Visit `https://stepstylebd.com/install` once
3. **DELETE this route immediately after** for security

---

### **STEP 10: Set Up Storage Link**

If you have SSH access:
```bash
php artisan storage:link
```

**If you don't have SSH access:**
1. Create a symbolic link manually in File Manager, OR
2. Create a temporary route:
```php
Route::get('/storage-link', function() {
    Artisan::call('storage:link');
    return 'Storage linked!';
});
```
3. Visit the URL once, then delete the route

---

### **STEP 11: Configure PHP Settings**

In cPanel, go to **Select PHP Version** or **MultiPHP INI Editor**:

**Required PHP Extensions:**
- ✅ `php-mbstring`
- ✅ `php-xml`
- ✅ `php-curl`
- ✅ `php-zip`
- ✅ `php-gd`
- ✅ `php-mysql`
- ✅ `php-openssl`
- ✅ `php-pdo`
- ✅ `php-tokenizer`
- ✅ `php-json`
- ✅ `php-fileinfo`

**PHP Settings:**
```
memory_limit = 256M (or higher)
upload_max_filesize = 20M
post_max_size = 20M
max_execution_time = 300
```

---

### **STEP 12: Set Up Cron Jobs**

In cPanel, go to **Cron Jobs**:

#### 12.1 Queue Worker (if using queues)
```bash
* * * * * cd /home/username/public_html && php artisan schedule:run >> /dev/null 2>&1
```

#### 12.2 Laravel Scheduler
```bash
* * * * * cd /home/username/public_html && php artisan schedule:run >> /dev/null 2>&1
```

**Note**: Replace `/home/username/public_html` with your actual path. You can find it in cPanel → File Manager → Current Path.

---

### **STEP 13: Configure Email**

1. In cPanel, go to **Email Accounts**
2. Create an email: `noreply@stepstylebd.com`
3. Use these credentials in your `.env` file for `MAIL_*` settings

---

### **STEP 14: SSL Certificate**

1. In cPanel, go to **SSL/TLS Status**
2. Install a free SSL certificate (Let's Encrypt) if available
3. Force HTTPS redirect by adding to `.htaccess`:
```apache
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

---

### **STEP 15: Test Your Deployment**

1. Visit `https://stepstylebd.com`
2. Check if the homepage loads
3. Test product pages
4. Test user registration/login
5. Test checkout process
6. Check error logs: `storage/logs/laravel.log`

---

## 🔧 Troubleshooting Common Issues

### Issue 1: 500 Internal Server Error
**Solutions:**
- Check file permissions (`storage/` and `bootstrap/cache/` should be `775`)
- Check `.env` file exists and has correct values
- Check `APP_KEY` is set
- Check error logs: `storage/logs/laravel.log`
- Enable `APP_DEBUG=true` temporarily to see errors

### Issue 2: Styles/CSS Not Loading
**Solutions:**
- Ensure `npm run build` was run before deployment
- Check `public/build/` folder exists and has files
- Clear cache: `php artisan cache:clear`
- Check file permissions on `public/` folder

### Issue 3: Database Connection Error
**Solutions:**
- Verify database credentials in `.env`
- Check database host (might be `localhost` or `127.0.0.1`)
- Ensure database user has proper permissions
- Check if database exists in phpMyAdmin

### Issue 4: Storage Files Not Accessible
**Solutions:**
- Run `php artisan storage:link`
- Check `public/storage` symlink exists
- Verify file permissions on `storage/app/public/`

### Issue 5: Route Not Found (404)
**Solutions:**
- Check `.htaccess` file exists in `public/`
- Verify `mod_rewrite` is enabled
- Clear route cache: `php artisan route:clear`
- Check `APP_URL` in `.env` matches your domain

---

## 📝 Post-Deployment Checklist

- [ ] Website loads at `https://stepstylebd.com`
- [ ] All images display correctly
- [ ] CSS and JavaScript files load
- [ ] Database connection works
- [ ] User registration/login works
- [ ] Product pages display correctly
- [ ] Shopping cart functions properly
- [ ] Checkout process works
- [ ] Email sending works (test with contact form)
- [ ] SSL certificate is active (HTTPS)
- [ ] Error logging is working
- [ ] Storage symlink is created
- [ ] File uploads work
- [ ] Cron jobs are set up (if needed)
- [ ] `APP_DEBUG=false` in production
- [ ] Remove any temporary installation routes

---

## 🔒 Security Best Practices

1. **Never commit `.env` file** - Keep it secure
2. **Set `APP_DEBUG=false`** in production
3. **Use strong `APP_KEY`** - Generate with `php artisan key:generate`
4. **Protect sensitive directories** - Add `.htaccess` to prevent direct access:
   ```apache
   # In storage/ and bootstrap/cache/
   Deny from all
   ```
5. **Regular backups** - Set up automated database backups in cPanel
6. **Keep Laravel updated** - Regularly update dependencies
7. **Use HTTPS** - Always use SSL certificates
8. **Strong passwords** - Use complex passwords for database and admin accounts

---

## 📞 Support

If you encounter issues:
1. Check `storage/logs/laravel.log` for detailed error messages
2. Check cPanel error logs
3. Verify all file permissions are correct
4. Ensure all PHP extensions are installed
5. Contact your hosting provider if server-level issues persist

---

## 🎉 Success!

Once all steps are completed, your Laravel e-commerce application should be live at `https://stepstylebd.com`!

**Remember**: Keep your `.env` file secure and never share it publicly.

