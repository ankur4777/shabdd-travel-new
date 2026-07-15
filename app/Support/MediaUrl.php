<?php

namespace App\Support;

use Illuminate\Support\Str;

class MediaUrl
{
    public const DEFAULT_IMAGE = 'images/couple-bg.jpg';
    public const DEFAULT_SEASONAL_IMAGE = 'images/himachal.jpg';

    public static function asset(?string $path, string $fallback = self::DEFAULT_IMAGE): string
    {
        $path = trim((string) $path);

        if ($path === '') {
            return asset($fallback);
        }

        if (Str::startsWith($path, ['http://', 'https://', '//', 'data:'])) {
            return $path;
        }

        $normalizedPath = ltrim($path, '/');

        if (Str::startsWith($normalizedPath, ['storage/', 'images/', 'css/', 'js/', 'fonts/'])) {
            return asset($normalizedPath);
        }

        return asset('storage/' . $normalizedPath);
    }

    public static function relative(?string $path, string $fallback = self::DEFAULT_IMAGE): string
    {
        $path = trim((string) $path);

        if ($path === '') {
            return '/' . ltrim($fallback, '/');
        }

        if (Str::startsWith($path, ['http://', 'https://', '//', 'data:'])) {
            return $path;
        }

        $normalizedPath = ltrim($path, '/');

        if (Str::startsWith($normalizedPath, ['storage/', 'images/', 'css/', 'js/', 'fonts/'])) {
            return '/' . $normalizedPath;
        }

        return '/storage/' . $normalizedPath;
    }
}
