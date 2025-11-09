# Laravel Dusk Setup Instructions for E-commerce Application

This guide provides comprehensive setup instructions for a fresh Laravel 12 project with Laravel Dusk 7+ for browser testing, including headful Chrome configuration and sample data seeding for an e-commerce application.

## Prerequisites

- PHP 8.2 or higher (required for Laravel 12)
- Composer
- Node.js 18+ and npm
- Chrome or Chromium browser (for headful testing)
- A database (MySQL, PostgreSQL, SQLite, etc.)

## Step 1: Create a Fresh Laravel 12 Project

Create a new Laravel project using Composer:

```bash
composer create-project laravel/laravel shoe-ecommerce "12.*" --prefer-dist
cd shoe-ecommerce
```

## Step 2: Install Project Dependencies

Install PHP and Node.js dependencies:

```bash
composer install
npm install
npm run build
```

## Step 3: Environment Configuration

1. Copy the environment file and generate an application key:

```bash
cp .env.example .env
php artisan key:generate
```

2. Configure your `.env` file with the following key settings:

```env
APP_NAME="Shoe E-commerce"
APP_ENV=local
APP_KEY=base64:your-generated-key
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://127.0.0.1:8000

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shoe_ecommerce
DB_USERNAME=your_username
DB_PASSWORD=your_password

CACHE_STORE=database
QUEUE_CONNECTION=database
SESSION_DRIVER=database
```

3. Create the database specified in your `.env` file.

## Step 4: Install and Configure Laravel Dusk

1. Install Laravel Dusk as a development dependency:

```bash
composer require laravel/dusk --dev
```

2. Install Dusk into your application:

```bash
php artisan dusk:install
```

This command will create the `tests/Browser` directory and a base `DuskTestCase.php` file.

3. Configure Dusk in `tests/DuskTestCase.php` for **headful testing** (visible browser window):

```php
<?php

namespace Tests;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Support\Collection;
use Laravel\Dusk\TestCase as BaseTestCase;
use PHPUnit\Framework\Attributes\BeforeClass;

abstract class DuskTestCase extends BaseTestCase
{
    /**
     * Prepare for Dusk test execution.
     */
    #[BeforeClass]
    public static function prepare(): void
    {
        if (! static::runningInSail()) {
            static::startChromeDriver(['--port=9515']);
        }
    }

    /**
     * Create the RemoteWebDriver instance.
     */
    protected function driver(): RemoteWebDriver
    {
        $options = (new ChromeOptions)->addArguments(collect([
            $this->shouldStartMaximized() ? '--start-maximized' : '--window-size=1920,1080',
            '--disable-search-engine-choice-screen',
            '--disable-smooth-scrolling',
        ])->unless($this->hasHeadlessDisabled(), function (Collection $items) {
            return $items->merge([
                // Removed --disable-gpu and --headless=new for headful testing
            ]);
        })->all());

        return RemoteWebDriver::create(
            $_ENV['DUSK_DRIVER_URL'] ?? env('DUSK_DRIVER_URL') ?? 'http://localhost:9515',
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY, $options
            )
        );
    }
}
```

## Step 5: Set Up Headful Chrome and ChromeDriver

### Install Chrome/Chromium

**On Ubuntu/Debian:**

```bash
sudo apt-get update
sudo apt-get install -y wget gnupg
wget -q -O - https://dl.google.com/linux/linux_signing_key.pub | sudo apt-key add -
echo "deb [arch=amd64] http://dl.google.com/linux/chrome/deb/ stable main" | sudo tee /etc/apt/sources.list.d/google-chrome.list
sudo apt-get update
sudo apt-get install -y google-chrome-stable
```

**On CentOS/RHEL/Fedora:**

```bash
sudo dnf install -y google-chrome-stable
```

**On macOS (using Homebrew):**

```bash
brew install --cask google-chrome
```

**On Windows:**

Download and install Chrome from the official website: https://www.google.com/chrome/

### Install ChromeDriver

**Using npm (recommended for consistency):**

```bash
npm install -g chromedriver
```

**Or download manually:**

1. Check your Chrome version: `google-chrome --version`
2. Download the matching ChromeDriver from: https://chromedriver.chromium.org/downloads
3. Extract and add to your system PATH

### Start ChromeDriver Server

For testing, you'll need to run ChromeDriver in the background. Add this to your test scripts or CI/CD pipeline:

```bash
chromedriver --port=9515 &
```

## Step 6: Database Setup and Migrations

1. Run database migrations:

```bash
php artisan migrate
```

2. (Optional) If you have existing migrations for the e-commerce features, run them:

```bash
php artisan migrate
```

## Step 7: Seed Sample Data

The e-commerce application includes several seeders for sample data. Run them in the following order:

1. Seed basic data:

```bash
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=SubcategorySeeder
php artisan db:seed --class=ChildCategorySeeder
php artisan db:seed --class=BrandSeeder
php artisan db:seed --class=ColorSeeder
php artisan db:seed --class=SizeSeeder
php artisan db:seed --class=CouponSeeder
```

2. Seed product-related data:

```bash
php artisan db:seed --class=ProductSeeder
php artisan db:seed --class=ProductVariantSeeder
php artisan db:seed --class=ProductImageSeeder
```

3. Seed additional content:

```bash
php artisan db:seed --class=BannerSeeder
```

4. Run all seeders at once (after ensuring proper order):

```bash
php artisan db:seed
```

Note: The `DatabaseSeeder.php` should be configured to call all seeders in the correct order.

## Step 8: Run the Application

1. Start the Laravel development server:

```bash
php artisan serve
```

The application will be available at `http://127.0.0.1:8000`

## Step 9: Run Dusk Tests

1. Ensure ChromeDriver is running (from Step 5.3)

2. Run all Dusk tests:

```bash
php artisan dusk
```

3. Run specific test files:

```bash
php artisan dusk tests/Browser/HomePageTest.php
php artisan dusk tests/Browser/ProductFlowTest.php
php artisan dusk tests/Browser/AuthenticationTest.php
```

4. Run tests with specific options:

```bash
# Run tests in headful mode (visible browser window)
php artisan dusk

# Run tests with verbose output
php artisan dusk --verbose

# Run tests and stop on first failure
php artisan dusk --stop-on-failure
```

## Step 10: CI/CD Integration (Optional)

For continuous integration, add the following to your CI pipeline:

```yaml
# Example GitHub Actions workflow
- name: Setup Chrome
  run: |
    sudo apt-get update
    sudo apt-get install -y google-chrome-stable

- name: Install ChromeDriver
  run: npm install -g chromedriver

- name: Start ChromeDriver
  run: chromedriver --port=9515 &
  env:
    DISPLAY: :99

- name: Run Dusk Tests
  run: php artisan dusk
  env:
    APP_URL: http://127.0.0.1:8000
```

## Troubleshooting

### Common Issues

1. **ChromeDriver connection refused:**
   - Ensure ChromeDriver is running on port 9515
   - Check that Chrome/Chromium is properly installed

2. **Tests failing due to missing elements:**
   - Verify APP_URL in .env matches the test environment
   - Check that sample data is properly seeded

3. **Headful mode issues:**
    - Ensure Chrome browser is properly installed and accessible
    - Check that ChromeDriver version matches your Chrome version
    - Verify display permissions if running in a headless environment

4. **Database connection issues:**
   - Verify database credentials in .env
   - Ensure database server is running

### Useful Commands

- Clear Dusk screenshots: `rm -rf tests/Browser/screenshots/*`
- Clear Dusk console logs: `rm -rf tests/Browser/console/*`
- Update Dusk: `composer update laravel/dusk`

## Additional Resources

- [Laravel Dusk Documentation](https://laravel.com/docs/dusk)
- [ChromeDriver Documentation](https://chromedriver.chromium.org/)
- [Laravel Testing Documentation](https://laravel.com/docs/testing)