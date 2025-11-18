# Quick Deployment Checklist for stepstylebd.com

## Pre-Deployment (Local)

- [ ] Run `composer install --no-dev --optimize-autoloader`
- [ ] Run `npm install`
- [ ] Run `npm run build`
- [ ] Run `php artisan config:clear`
- [ ] Run `php artisan cache:clear`
- [ ] Run `php artisan view:clear`
- [ ] Run `php artisan route:clear`
- [ ] Create `.zip` file excluding: `node_modules/`, `.git/`, `tests/`, `.env`

## cPanel Setup

- [ ] Log in to cPanel
- [ ] Create MySQL database
- [ ] Create database user
- [ ] Grant user privileges to database
- [ ] Note down database credentials

## File Upload

- [ ] Upload Laravel files to server
- [ ] Upload `public/` contents to `public_html/`
- [ ] Set `storage/` permissions to `775`
- [ ] Set `bootstrap/cache/` permissions to `775`

## Configuration

- [ ] Create `.env` file in Laravel root
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Set `APP_URL=https://stepstylebd.com`
- [ ] Configure database credentials
- [ ] Generate `APP_KEY` (run `php artisan key:generate` or add manually)
- [ ] Configure email settings
- [ ] Configure payment gateway keys (Stripe, PayPal)
- [ ] Configure Twilio credentials (if using SMS)

## Database

- [ ] Import database (if you have backup)
- [ ] OR run migrations: `php artisan migrate --force`
- [ ] Run seeders: `php artisan db:seed --force` (if needed)

## Laravel Setup

- [ ] Run `php artisan storage:link`
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`

## PHP Configuration

- [ ] Check PHP version (8.2+)
- [ ] Enable required PHP extensions
- [ ] Set `memory_limit = 256M`
- [ ] Set `upload_max_filesize = 20M`

## Cron Jobs

- [ ] Set up Laravel scheduler cron job
- [ ] Set up queue worker (if using queues)

## SSL & Security

- [ ] Install SSL certificate
- [ ] Force HTTPS redirect
- [ ] Verify `APP_DEBUG=false`
- [ ] Remove any temporary installation routes

## Testing

- [ ] Visit `https://stepstylebd.com`
- [ ] Test homepage loads
- [ ] Test product pages
- [ ] Test user registration
- [ ] Test login
- [ ] Test shopping cart
- [ ] Test checkout
- [ ] Test file uploads
- [ ] Test email sending

## Post-Deployment

- [ ] Monitor error logs
- [ ] Set up automated backups
- [ ] Test all critical features
- [ ] Update DNS if needed

---

**Estimated Time**: 1-2 hours for first-time deployment

