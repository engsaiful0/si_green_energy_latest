<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Resolves and stores CMS images.
 *
 * Stored paths are always relative to the web root so they can be passed to asset():
 *   - bundled theme images: "img/banner/banner-1.jpg"
 *   - uploaded images:      "storage/uploads/sliders/abc.jpg" (public disk)
 *   - external images:      "https://..."
 */
class Media
{
    private const UPLOAD_PREFIX = 'storage/';

    public static function url(?string $path, ?string $fallback = null): string
    {
        $path = $path ?: $fallback;

        if (!$path) {
            return '';
        }

        if (preg_match('#^(https?:)?//#i', $path) || str_starts_with($path, 'data:')) {
            return $path;
        }

        return asset(ltrim($path, '/'));
    }

    /**
     * Store an uploaded image on the public disk and return its web path.
     */
    public static function store(UploadedFile $file, string $folder): string
    {
        $stored = $file->store('uploads/' . trim($folder, '/'), 'public');

        return self::UPLOAD_PREFIX . $stored;
    }

    /**
     * Replace an image: store the new upload and delete the previous upload (never theme files).
     */
    public static function replace(?UploadedFile $file, ?string $current, string $folder): ?string
    {
        if (!$file) {
            return $current;
        }

        $new = self::store($file, $folder);
        self::delete($current);

        return $new;
    }

    /**
     * Delete a previously uploaded file. Bundled theme images and external URLs are left alone.
     */
    public static function delete(?string $path): void
    {
        if ($path && str_starts_with($path, self::UPLOAD_PREFIX)) {
            Storage::disk('public')->delete(substr($path, strlen(self::UPLOAD_PREFIX)));
        }
    }

    /**
     * Validation rules for an image upload field.
     */
    public static function rules(bool $required = false): array
    {
        return [$required ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:4096'];
    }
}
