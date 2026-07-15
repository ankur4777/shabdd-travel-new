<?php

namespace App\Support;

use Filament\Forms\Components\BaseFileUpload;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use League\Flysystem\UnableToCheckFileExistence;

class FilamentUploadPreview
{
    public static function isImageUpload(BaseFileUpload $component): bool
    {
        foreach ($component->getAcceptedFileTypes() ?? [] as $type) {
            if ($type === 'image/*' || Str::startsWith($type, 'image/')) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param  string|array<string, string>|null  $storedFileNames
     * @return array{name: string, size: int, type: ?string, url: string}|null
     */
    public static function resolve(BaseFileUpload $component, string $file, string|array|null $storedFileNames): ?array
    {
        $file = trim($file);

        if ($file === '') {
            return null;
        }

        $normalizedPath = ltrim($file, '/');
        $diskPath = Str::startsWith($normalizedPath, 'storage/')
            ? Str::after($normalizedPath, 'storage/')
            : $normalizedPath;

        $url = MediaUrl::asset($file);
        $size = 0;
        $type = null;

        if (! Str::startsWith($file, ['http://', 'https://', '//', 'data:'])) {
            $disk = $component->getDisk();

            try {
                if ($disk->exists($diskPath)) {
                    $url = $component->getDiskName() === 'public'
                        ? MediaUrl::asset($diskPath)
                        : $disk->url($diskPath);
                    $size = $disk->size($diskPath);
                    $type = $disk->mimeType($diskPath);
                }
            } catch (UnableToCheckFileExistence) {
                //
            }

            if ($size === 0) {
                $publicPath = public_path($normalizedPath);

                if (File::exists($publicPath)) {
                    $url = asset($normalizedPath);
                    $size = File::size($publicPath);
                    $type = File::mimeType($publicPath);
                }
            }
        }

        return [
            'name' => self::resolveName($component, $file, $storedFileNames),
            'size' => $size,
            'type' => $type,
            'url' => Str::sanitizeUrl($url),
        ];
    }

    /**
     * @param  string|array<string, string>|null  $storedFileNames
     */
    private static function resolveName(BaseFileUpload $component, string $file, string|array|null $storedFileNames): string
    {
        $name = $component->isMultiple()
            ? (is_array($storedFileNames) ? ($storedFileNames[$file] ?? null) : null)
            : (is_string($storedFileNames) ? $storedFileNames : null);

        return $name ?: basename((string) parse_url($file, PHP_URL_PATH));
    }
}
