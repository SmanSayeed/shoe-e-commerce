# CSS/JS Not Loading - Fix Guide

## Problem
Website loads but CSS and JavaScript files are not loading (styles broken, JS not working).

## Root Cause
The root `.htaccess` file redirects all requests to `public/`, but Vite assets are in `public/build/` and need to be accessible at `/build/` URL path.

## Solution

### Step 1: Upload Updated `.htaccess`
I've updated your root `.htaccess` file. Upload it to your cPanel root directory (same level as `app/`, `public/`, etc.).

### Step 2: Verify Asset Paths
Make sure your assets are built and in the correct location:

**On Server:**
```
public_html/
├── public/
│   ├── build/
│   │   ├── assets/
│   │   │   ├── app-xxx.js
│   │   │   ├── app-xxx.css
│   │   │   └── ...
│   │   └── manifest.json
│   └── index.php
```

### Step 3: Check `.env` Configuration
In your `.env` file on the server, make sure:

```env
APP_URL=https://stepstylebd.com
APP_ENV=production
APP_DEBUG=false
```

### Step 4: Clear Laravel Cache
If you have SSH access, run:
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

Or create a temporary route to clear cache:
```php
Route::get('/clear-cache', function() {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    return 'Cache cleared!';
});
```
Visit `https://stepstylebd.com/clear-cache` once, then **DELETE this route**.

### Step 5: Verify Asset URLs
Open your website and check the browser console (F12):
- Look for 404 errors on CSS/JS files
- Check the Network tab to see what URLs are being requested
- Verify they're requesting `/build/assets/...` not `/public/build/assets/...`

## Common Issues & Fixes

### Issue 1: Assets return 404
**Fix:** Make sure `public/build/` directory exists and has files. Rebuild assets locally and re-upload `public/build/` folder.

### Issue 2: Assets load but paths are wrong
**Fix:** Check `APP_URL` in `.env` - it should be `https://stepstylebd.com` (no trailing slash).

### Issue 3: Mixed Content (HTTP/HTTPS)
**Fix:** Ensure `APP_URL` uses `https://` not `http://`.

### Issue 4: Assets still not loading after `.htaccess` update
**Fix:** 
1. Check file permissions on `public/build/` (should be 755)
2. Verify `.htaccess` is in root directory
3. Check if `mod_rewrite` is enabled in cPanel

## Testing

After uploading the updated `.htaccess`:

1. Clear browser cache (Ctrl+F5)
2. Visit `https://stepstylebd.com`
3. Open browser DevTools (F12)
4. Check Console for errors
5. Check Network tab - verify CSS/JS files load with 200 status

## If Still Not Working

1. **Check actual asset URLs:**
   - Right-click page → View Source
   - Look for `<link>` and `<script>` tags
   - See what URLs they're using

2. **Test direct asset access:**
   - Try accessing: `https://stepstylebd.com/build/assets/app-xxx.css` directly
   - If it works, the issue is with Laravel/Vite configuration
   - If it doesn't, the issue is with `.htaccess` or file structure

3. **Rebuild assets:**
   - Locally run: `npm run build`
   - Upload the entire `public/build/` folder to server

4. **Check server error logs:**
   - cPanel → Metrics → Errors
   - Look for any related errors

## Quick Fix Checklist

- [ ] Updated `.htaccess` uploaded to root
- [ ] `APP_URL=https://stepstylebd.com` in `.env`
- [ ] `public/build/` directory exists with files
- [ ] Cleared Laravel cache
- [ ] Cleared browser cache
- [ ] Checked browser console for errors
- [ ] Verified asset files exist on server

