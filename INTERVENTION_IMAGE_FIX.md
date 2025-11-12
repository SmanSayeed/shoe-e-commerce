# Intervention Image v3 TypeError Fix

## Problem

**Error**: `TypeError: Intervention\Image\Image::encode() expects an EncoderInterface for the first argument but receives a string instead`

**Location**: `app/Http/Controllers/Admin/SiteSettingController.php:139`

## Root Cause

In Intervention Image v3, the API has changed significantly from v2. The `encode()` method now requires an `EncoderInterface` instance, not a string format name. The incorrect code was:

```php
$encoded = $image->encode($file->getClientOriginalExtension(), 90);
```

This was trying to pass a string (like "png" or "jpg") as the first argument, but v3 expects an encoder object.

## Solution

The fix uses the `save()` method directly (similar to how BannerController works), which handles encoding automatically based on the file extension. The corrected approach:

1. **Save to temporary file**: Use `save()` to save the processed image to a temporary location
2. **Read file content**: Read the processed image content from the temp file
3. **Store in Laravel Storage**: Use `Storage::put()` to store the image
4. **Clean up**: Delete the temporary file

## Code Changes

### Before (Incorrect):
```php
// Encode and save
$encoded = $image->encode($file->getClientOriginalExtension(), 90);

// Store the image
Storage::put($path, $encoded, 'public');
```

### After (Correct):
```php
// Create a temporary file path
$tempPath = sys_get_temp_dir() . '/' . uniqid('img_', true) . '.' . $file->getClientOriginalExtension();

// Save the image to temporary location with quality
$image->save($tempPath, 90);

// Read the processed image content
$imageContent = file_get_contents($tempPath);

// Store the image in Storage
Storage::put($path, $imageContent, 'public');

// Clean up temporary file
if (file_exists($tempPath)) {
    @unlink($tempPath);
}
```

## Complete Fixed Method

```php
private function handleImageUpload($file, string $folder, ?int $width = null, ?int $height = null): string
{
    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    $path = "site-settings/{$folder}/{$filename}";

    // Handle SVG files differently (no resizing)
    if ($file->getClientOriginalExtension() === 'svg') {
        Storage::putFileAs("site-settings/{$folder}", $file, $filename, 'public');
        return $path;
    }

    // Resize and optimize image using Intervention Image v3
    $manager = new ImageManager(new Driver());
    $image = $manager->read($file->getRealPath());

    if ($width && $height) {
        $image->cover($width, $height);
    }

    // Create a temporary file path
    $tempPath = sys_get_temp_dir() . '/' . uniqid('img_', true) . '.' . $file->getClientOriginalExtension();
    
    // Save the image to temporary location with quality
    $image->save($tempPath, 90);
    
    // Read the processed image content
    $imageContent = file_get_contents($tempPath);
    
    // Store the image in Storage
    Storage::put($path, $imageContent, 'public');
    
    // Clean up temporary file
    if (file_exists($tempPath)) {
        @unlink($tempPath);
    }

    return $path;
}
```

## Why This Works

1. **`save()` method**: In Intervention Image v3, `save()` automatically handles encoding based on the file extension. It accepts:
   - First parameter: File path (string)
   - Second parameter: Quality (integer, 0-100)

2. **Temporary file approach**: Since we're using Laravel's Storage facade (which works with the storage disk), we need to:
   - Process the image first (resize, optimize)
   - Save it temporarily
   - Read the content
   - Store it via Storage

3. **Automatic cleanup**: The temporary file is deleted after use to prevent disk space issues.

## Alternative Approaches (Not Used)

### Option 1: Direct Storage Path (Not Recommended)
```php
// This would require knowing the full storage path
$storagePath = Storage::path($path);
$image->save($storagePath, 90);
```
**Issue**: Requires ensuring directory exists and handling permissions.

### Option 2: Using Encoder Classes (More Complex)
```php
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\PngEncoder;

$encoder = match($file->getClientOriginalExtension()) {
    'jpg', 'jpeg' => new JpegEncoder(90),
    'png' => new PngEncoder(90),
    default => new JpegEncoder(90),
};
$encoded = $image->encode($encoder);
```
**Issue**: More complex, requires matching file types to encoders.

## Testing

After applying the fix, test:

1. **Logo Upload**: Upload a PNG/JPG logo (should resize to 300x300)
2. **Favicon Upload**: Upload a PNG/JPG favicon (should resize to 32x32)
3. **OG Image Upload**: Upload a PNG/JPG OG image (should resize to 1200x630)
4. **SVG Files**: Upload SVG files (should work without resizing)
5. **File Deletion**: Delete uploaded images (should work correctly)

## Verification

To verify the fix works:

```bash
# Test the upload functionality
# Navigate to: /admin/site-settings
# Try uploading images in the Branding and SEO tabs
```

## Related Files

- **Fixed**: `app/Http/Controllers/Admin/SiteSettingController.php`
- **Reference**: `app/Http/Controllers/Admin/BannerController.php` (uses similar pattern)

## Notes

- The temporary file approach is safe and efficient
- Quality is set to 90% for good balance between file size and image quality
- SVG files bypass image processing (as they're vector graphics)
- The `@unlink()` suppresses errors if the file is already deleted (defensive programming)

---

**Status**: ✅ Fixed
**Date**: November 12, 2025
**Intervention Image Version**: 3.x

