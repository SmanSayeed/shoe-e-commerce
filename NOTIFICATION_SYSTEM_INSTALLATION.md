# Real-time Notification System Installation Guide

## Overview
This notification system provides real-time order notifications for admin users using Laravel + Pusher (Free Plan).

## Installation Steps

### 1. Install Dependencies

**For Shared Hosting (cPanel):**
- Upload the project files
- Use cPanel's Composer interface or terminal to run:
  ```bash
  composer install
  ```
- Or manually upload the `vendor/pusher/pusher-php-server` package if composer is not available

**For Local Development:**
```bash
composer install
```

### 2. Run Migrations

**Via cPanel Terminal:**
```bash
php artisan migrate
```

**Via Web Interface (if available):**
- Navigate to your Laravel application
- Use a migration runner tool if available

**Manual SQL (if migrations can't run):**
- Execute the SQL from `database/migrations/2025_01_15_100000_add_columns_to_custom_notifications_table.php`
- Execute the SQL from `database/migrations/2025_01_15_100001_create_notification_settings_table.php`

### 3. Configure Pusher

1. **Get Pusher Credentials:**
   - Sign up at https://dashboard.pusher.com/ (Free plan available)
   - Create a new app
   - Copy your App ID, Key, Secret, and Cluster

2. **Configure in Admin Panel:**
   - Login as admin
   - Go to **Settings > Notification Settings**
   - Enter your Pusher credentials:
     - App ID
     - Key
     - Secret
     - Cluster (e.g., ap2, us2, eu)
   - Enable "Enable Real-time Notifications"
   - Click "Test Connection" to verify
   - Click "Save Settings"

### 4. Verify Installation

1. **Check Routes:**
   - `/admin/notifications` - Should show notifications page
   - `/admin/notification-settings` - Should show settings page

2. **Test Notifications:**
   - Place a test order from frontend
   - Check admin panel notification dropdown (bell icon)
   - Notification should appear in real-time

## Features

### Notification Types
- **Order Success**: When a new order is placed
- **Order Cancelled**: When an order is cancelled
- **Order Failed**: When payment fails (if implemented)
- **Order Status Changed**: When order status is updated

### Pages
- **Notifications List**: `/admin/notifications` - View all notifications with filters and pagination
- **Notification Settings**: `/admin/notification-settings` - Configure Pusher credentials

### Real-time Updates
- Notifications appear instantly in the header dropdown
- Unread count badge updates automatically
- Browser notifications (if permission granted)

## Troubleshooting

### Notifications Not Appearing
1. Check Pusher credentials are correct
2. Verify "Enable Real-time Notifications" is checked
3. Check browser console for errors
4. Verify Pusher app is active in Pusher dashboard

### Real-time Not Working
1. Check Pusher connection test in settings
2. Verify JavaScript console for Pusher errors
3. Ensure Pusher JS library is loading (check Network tab)
4. Check if notifications.js file is accessible at `/js/admin/notifications.js`

### Migration Errors
- Ensure database user has CREATE/ALTER permissions
- Check if `custom_notifications` table exists
- Verify foreign key constraints are supported

## File Structure

```
app/
├── Models/
│   ├── Notification.php
│   └── NotificationSetting.php
├── Services/
│   ├── NotificationService.php
│   └── PusherService.php
└── Http/Controllers/Admin/
    ├── NotificationController.php
    └── NotificationSettingsController.php

database/migrations/
├── 2025_01_15_100000_add_columns_to_custom_notifications_table.php
└── 2025_01_15_100001_create_notification_settings_table.php

resources/views/admin/
├── notifications/
│   └── index.blade.php
└── notification-settings/
    └── index.blade.php

public/js/admin/
└── notifications.js
```

## Notes for Shared Hosting

- Pusher JS is loaded via CDN (no build process needed)
- notifications.js is copied to public folder (accessible without build)
- All Pusher credentials stored in database (not .env)
- No shell access required for configuration

## Support

If you encounter issues:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Check browser console for JavaScript errors
3. Verify Pusher dashboard for connection status
4. Ensure all migrations ran successfully

