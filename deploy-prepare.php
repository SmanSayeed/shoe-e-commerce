<?php
/**
 * Deployment Preparation Script
 * Run this script locally before uploading to cPanel
 * 
 * Usage: php deploy-prepare.php
 */

echo "🚀 Laravel Deployment Preparation Script\n";
echo "========================================\n\n";

// Check if we're in Laravel root
if (!file_exists('artisan')) {
    die("❌ Error: Please run this script from the Laravel root directory.\n");
}

echo "📦 Step 1: Clearing caches...\n";
exec('php artisan config:clear', $output, $return);
exec('php artisan cache:clear', $output, $return);
exec('php artisan view:clear', $output, $return);
exec('php artisan route:clear', $output, $return);
echo "✅ Caches cleared\n\n";

echo "🔧 Step 2: Optimizing for production...\n";
exec('php artisan config:cache', $output, $return);
exec('php artisan route:cache', $output, $return);
exec('php artisan view:cache', $output, $return);
echo "✅ Application optimized\n\n";

echo "📝 Step 3: Checking .env file...\n";
if (!file_exists('.env')) {
    echo "⚠️  Warning: .env file not found. Make sure to create it on the server.\n";
} else {
    echo "✅ .env file exists (will be excluded from upload)\n";
}
echo "\n";

echo "🔑 Step 4: Checking APP_KEY...\n";
if (file_exists('.env')) {
    $envContent = file_get_contents('.env');
    if (strpos($envContent, 'APP_KEY=') === false || strpos($envContent, 'APP_KEY=base64:') === false) {
        echo "⚠️  Warning: APP_KEY not set. Run 'php artisan key:generate' before deployment.\n";
    } else {
        echo "✅ APP_KEY is set\n";
    }
}
echo "\n";

echo "📦 Step 5: Building assets...\n";
if (file_exists('package.json')) {
    echo "   Running npm install...\n";
    exec('npm install', $output, $return);
    echo "   Running npm run build...\n";
    exec('npm run build', $output, $return);
    echo "✅ Assets built\n";
} else {
    echo "⚠️  Warning: package.json not found. Skipping asset build.\n";
}
echo "\n";

echo "📋 Step 6: Files to EXCLUDE from upload:\n";
echo "   - node_modules/\n";
echo "   - .git/\n";
echo "   - tests/\n";
echo "   - .env\n";
echo "   - storage/logs/*\n";
echo "   - storage/framework/cache/*\n";
echo "   - storage/framework/sessions/*\n";
echo "   - storage/framework/views/*\n";
echo "   - .gitignore\n";
echo "   - .env.example\n";
echo "   - README.md\n";
echo "   - *.md (documentation files)\n";
echo "\n";

echo "📋 Step 7: Files to INCLUDE in upload:\n";
echo "   - app/\n";
echo "   - bootstrap/\n";
echo "   - config/\n";
echo "   - database/\n";
echo "   - public/ (contents go to public_html/)\n";
echo "   - resources/\n";
echo "   - routes/\n";
echo "   - storage/ (empty directories, will be populated)\n";
echo "   - vendor/\n";
echo "   - artisan\n";
echo "   - composer.json\n";
echo "   - composer.lock\n";
echo "\n";

echo "✅ Preparation complete!\n\n";
echo "📝 Next steps:\n";
echo "   1. Create a .zip file excluding the files listed above\n";
echo "   2. Upload to cPanel\n";
echo "   3. Follow the DEPLOYMENT_GUIDE_CPANEL.md instructions\n";
echo "\n";

