<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogImageService
{
    /**
     * Resolve an accessible URL from a stored relative path or external URL.
     */
    public static function resolveUrl(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        if (Storage::disk('public')->exists($path)) {
            return Storage::url($path);
        }

        if (file_exists(public_path($path))) {
            return asset($path);
        }

        return null;
    }

    /**
     * Store an uploaded image, resizing and compressing it via GD when available.
     */
    public function storeCompressed(
        UploadedFile $file,
        string $subDirectory = 'images/blog',
        int $maxDimension = 1600,
        int $quality = 82
    ): string {
        $subDirectory = trim($subDirectory, '/');
        $directory = public_path($subDirectory);

        if (! File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $realPath = $file->getRealPath();

        if (! $realPath || ! function_exists('imagecreatefromstring')) {
            return $this->storeOriginal($file, $subDirectory, $directory);
        }

        $raw = @file_get_contents($realPath);
        $source = $raw !== false ? @imagecreatefromstring($raw) : false;

        if (! $source) {
            return $this->storeOriginal($file, $subDirectory, $directory);
        }

        $source = $this->applyExifOrientation($source, $realPath, $file->getMimeType());

        $origWidth = imagesx($source);
        $origHeight = imagesy($source);

        if ($origWidth <= 0 || $origHeight <= 0) {
            return $this->storeOriginal($file, $subDirectory, $directory);
        }

        [$targetWidth, $targetHeight] = $this->fitDimensions($origWidth, $origHeight, $maxDimension);

        $mime = strtolower((string) $file->getMimeType());
        $preserveAlpha = in_array($mime, ['image/png', 'image/webp', 'image/gif'], true)
            && $this->hasTransparency($source, $origWidth, $origHeight);

        $canvas = imagecreatetruecolor($targetWidth, $targetHeight);

        if ($preserveAlpha) {
            imagealphablending($canvas, false);
            imagesavealpha($canvas, true);
            $transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
            imagefilledrectangle($canvas, 0, 0, $targetWidth, $targetHeight, $transparent);
        } else {
            // Fill white background so any opaque/semi-transparent PNG converts cleanly to JPEG.
            $white = imagecolorallocate($canvas, 255, 255, 255);
            imagefilledrectangle($canvas, 0, 0, $targetWidth, $targetHeight, $white);
        }

        imagecopyresampled($canvas, $source, 0, 0, 0, 0, $targetWidth, $targetHeight, $origWidth, $origHeight);

        $baseName = Str::uuid()->toString();

        if ($preserveAlpha && function_exists('imagewebp')) {
            $filename = $baseName.'.webp';
            $saved = @imagewebp($canvas, $directory.DIRECTORY_SEPARATOR.$filename, $quality);
        } elseif ($preserveAlpha) {
            $filename = $baseName.'.png';
            $saved = @imagepng($canvas, $directory.DIRECTORY_SEPARATOR.$filename, 6);
        } else {
            $filename = $baseName.'.jpg';
            imageinterlace($canvas, true);
            $saved = @imagejpeg($canvas, $directory.DIRECTORY_SEPARATOR.$filename, $quality);
        }

        if (! $saved) {
            return $this->storeOriginal($file, $subDirectory, $directory);
        }

        return $subDirectory.'/'.$filename;
    }

    /**
     * Delete an image stored on either the public disk or inside public/.
     */
    public function deleteFile(?string $path): void
    {
        if (blank($path) || Str::startsWith($path, ['http://', 'https://'])) {
            return;
        }

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            return;
        }

        $publicPath = public_path($path);

        if (File::exists($publicPath)) {
            File::delete($publicPath);
        }
    }

    private function storeOriginal(UploadedFile $file, string $subDirectory, string $directory): string
    {
        $extension = $file->getClientOriginalExtension() ?: $file->extension() ?: 'jpg';
        $filename = Str::uuid()->toString().'.'.strtolower($extension);
        $file->move($directory, $filename);

        return $subDirectory.'/'.$filename;
    }

    private function fitDimensions(int $width, int $height, int $maxDimension): array
    {
        $largest = max($width, $height);

        if ($largest <= $maxDimension) {
            return [$width, $height];
        }

        $scale = $maxDimension / $largest;

        return [
            max(1, (int) round($width * $scale)),
            max(1, (int) round($height * $scale)),
        ];
    }

    private function applyExifOrientation(\GdImage $image, string $path, ?string $mime): \GdImage
    {
        if (! function_exists('exif_read_data') || ! in_array(strtolower((string) $mime), ['image/jpeg', 'image/jpg', 'image/tiff'], true)) {
            return $image;
        }

        $exif = @exif_read_data($path);
        $orientation = (int) ($exif['Orientation'] ?? 1);

        return match ($orientation) {
            2 => $this->flipped($image, IMG_FLIP_HORIZONTAL),
            3 => imagerotate($image, 180, 0) ?: $image,
            4 => $this->flipped($image, IMG_FLIP_VERTICAL),
            5 => $this->flipped(imagerotate($image, -90, 0) ?: $image, IMG_FLIP_HORIZONTAL),
            6 => imagerotate($image, -90, 0) ?: $image,
            7 => $this->flipped(imagerotate($image, 90, 0) ?: $image, IMG_FLIP_HORIZONTAL),
            8 => imagerotate($image, 90, 0) ?: $image,
            default => $image,
        };
    }

    private function flipped(\GdImage $image, int $mode): \GdImage
    {
        imageflip($image, $mode);

        return $image;
    }

    private function hasTransparency(\GdImage $image, int $width, int $height): bool
    {
        // Sample grid points to detect meaningful alpha transparency quickly without scanning millions of pixels.
        $stepX = max(1, (int) floor($width / 25));
        $stepY = max(1, (int) floor($height / 25));

        for ($x = 0; $x < $width; $x += $stepX) {
            for ($y = 0; $y < $height; $y += $stepY) {
                $rgba = imagecolorat($image, $x, $y);
                $alpha = ($rgba >> 24) & 0x7F;
                if ($alpha > 0) {
                    return true;
                }
            }
        }

        return false;
    }
}

