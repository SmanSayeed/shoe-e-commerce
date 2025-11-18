# Troubleshooting 403 Forbidden Error

## Current Issue
Getting 403 Forbidden error after uploading `.htaccess` file.

## Step-by-Step Fix

### Step 1: Test Minimal .htaccess
I've created a minimal `.htaccess` file. Upload it to your root directory.

### Step 2: Check Directory Structure
Verify your structure on cPanel:
```
public_html/ (or your root)
├── .htaccess          ← Should be here
├── public/
│   ├── .htaccess      ← Should be here
│   ├── index.php
│   └── build/
└── app/, vendor/, etc.
```

### Step 3: Check File Permissions
In cPanel File Manager, verify:
- `.htaccess` (root) = **644**
- `public/.htaccess` = **644**
- `public/index.php` = **644**
- `public/` directory = **755**

### Step 4: Check if mod_rewrite is Enabled
1. In cPanel, look for **Apache Modules** or **Select PHP Version**
2. Ensure `mod_rewrite` is enabled
3. If you can't find it, contact your hosting provider

### Step 5: Test Direct Access
Try accessing these URLs directly:
1. `https://stepstylebd.com/public/index.php` - Should work
2. `https://stepstylebd.com/public/` - Should work
3. `https://stepstylebd.com/` - Should redirect to public/

### Step 6: Check Server Error Logs
1. Go to cPanel → **Metrics** → **Errors**
2. Look for recent errors related to `.htaccess` or 403
3. Share the error message if you see one

### Step 7: Alternative - Remove Root .htaccess Temporarily
If nothing works:
1. **Rename** root `.htaccess` to `.htaccess.backup`
2. Access: `https://stepstylebd.com/public/`
3. If this works, the issue is with the root `.htaccess`
4. If this doesn't work, the issue is elsewhere

### Step 8: Check cPanel Restrictions
Some hosting providers block certain `.htaccess` directives:
- Contact your hosting provider
- Ask if there are restrictions on `mod_rewrite` or `.htaccess` files
- Some shared hosting blocks certain rewrite rules

## Common Causes of 403

1. **File Permissions** - `.htaccess` should be 644, directories 755
2. **mod_rewrite Disabled** - Server doesn't support URL rewriting
3. **Hosting Restrictions** - Provider blocks certain directives
4. **Conflicting Rules** - Multiple `.htaccess` files conflicting
5. **Directory Permissions** - Parent directories not readable

## Quick Test Commands (if you have SSH)

```bash
# Check if mod_rewrite is enabled
php -m | grep rewrite

# Check file permissions
ls -la .htaccess
ls -la public/.htaccess

# Test Apache configuration
apache2ctl -t
```

## If Still Not Working

1. **Contact Hosting Support** - They can check server logs
2. **Try Different Approach** - Move Laravel files to match standard structure
3. **Check cPanel Error Logs** - Look for specific error messages

## Alternative Solution

If `.htaccess` redirect doesn't work, you might need to:
1. Change document root in cPanel to point to `public/` directory
2. Or restructure files (but you said you don't want to do this)

Let me know what you find in the error logs!

