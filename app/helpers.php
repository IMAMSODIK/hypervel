<?php

use Illuminate\Support\Facades\Storage;

if (! function_exists('storage_url')) {
    /**
     * Convert a stored file path (relative path on the public disk, or any
     * external URL) into a fully-resolvable URL that works on any domain.
     *
     * - External URLs (starting with http) are returned as-is.
     * - Relative paths (e.g. "hero_videos/abc.mp4") are resolved through
     *   Storage::disk('public')->url(), which emits "/storage/hero_videos/abc.mp4".
     *   The route registered in routes/web.php then serves them even without
     *   a public/storage symlink, so uploads work after deployment.
     *
     * @param  string|null  $path
     * @return string
     */
    function storage_url(?string $path): string
    {
        if (! $path) {
            return '';
        }

        if (filter_var($path, FILTER_VALIDATE_URL) !== false) {
            return $path; // already absolute http(s) URL
        }

        try {
            return Storage::disk('public')->url($path);
        } catch (\Throwable $e) {
            // Fallback: build URL manually from APP_URL if disk URL fails.
            return rtrim(config('app.url', ''), '/').'/storage/'.ltrim($path, '/');
        }
    }
}