<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    /**
     * Serve files from the public disk.
     * Works regardless of `php artisan storage:link` or `route:cache`.
     * Registration in routes/web.php guarantees it survives route caching,
     * unlike Laravel 11's auto-registered `serve` route.
     */
    public function serve(Request $request, string $path)
    {
        $disk = Storage::disk('public');

        if (! $disk->exists($path)) {
            abort(404);
        }

        $file = $disk->path($path);
        $mime = mime_content_type($file) ?: ($disk->mimeType($path) ?: 'application/octet-stream');

        return response()->file($file, [
            'Content-Type'        => $mime,
            'Cache-Control'       => 'public, max-age=31536000, immutable',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}