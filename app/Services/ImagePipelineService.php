<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImagePipelineService
{
    protected ImageManager $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver);
        $this->ensureSeedDirectoriesExist();
    }

    /**
     * Ensure storage directories for manual seed photos exist.
     */
    public function ensureSeedDirectoriesExist(): void
    {
        $categories = [
            'politics', 'india', 'world', 'business', 'sports',
            'tech', 'entertainment', 'opinion', 'lifestyle',
            'authors', 'videos', 'galleries', 'articles',
        ];

        foreach ($categories as $cat) {
            $dir = storage_path("app/seed-photos/{$cat}");
            if (! file_exists($dir)) {
                @mkdir($dir, 0755, true);
            }
        }
    }

    /**
     * Download or load a real photograph, generate 3 WebP sizes (400, 800, 1600),
     * generate a 24px blurred LQIP and data URI, and save into local public storage.
     *
     * @return array{path: string, path_800: string, path_400: string, path_lqip: string, srcset: string, lqip: string, source_used: string}
     */
    public function processAndStore(string $sourceUrl, string $slug, string $category = 'articles'): array
    {
        $safeSlug = Str::slug($slug);
        if (empty($safeSlug)) {
            $safeSlug = 'article-'.time();
        }

        $directory = "public/{$category}";
        Storage::makeDirectory($directory);

        $diskPublicPath = storage_path("app/public/{$category}");
        if (! file_exists($diskPublicPath)) {
            @mkdir($diskPublicPath, 0755, true);
        }

        [$binaryData, $sourceUsed] = $this->fetchImageDataWithFallbacks($sourceUrl, $safeSlug, $category, 1600, 900);

        // Process images with Intervention Image
        $image = $this->manager->decode($binaryData);

        // 1. Full Size 1600w
        $file1600 = "{$safeSlug}-1600.webp";
        $path1600 = "{$diskPublicPath}/{$file1600}";
        (clone $image)->scale(width: 1600)->save($path1600, quality: 85);

        // 2. Medium Size 800w
        $file800 = "{$safeSlug}-800.webp";
        $path800 = "{$diskPublicPath}/{$file800}";
        (clone $image)->scale(width: 800)->save($path800, quality: 82);

        // 3. Thumbnail / Mobile 400w
        $file400 = "{$safeSlug}-400.webp";
        $path400 = "{$diskPublicPath}/{$file400}";
        (clone $image)->scale(width: 400)->save($path400, quality: 80);

        // 4. Tiny 24px blurred LQIP placeholder
        $file24 = "{$safeSlug}-24.webp";
        $path24 = "{$diskPublicPath}/{$file24}";
        $lqipImg = (clone $image)->scale(width: 24);
        $lqipImg->save($path24, quality: 30);
        $lqipDataUri = (string) $lqipImg->encodeUsingFileExtension('webp', quality: 30)->toDataUri();

        $publicUrl1600 = "/storage/{$category}/{$file1600}";
        $publicUrl800 = "/storage/{$category}/{$file800}";
        $publicUrl400 = "/storage/{$category}/{$file400}";
        $publicUrl24 = "/storage/{$category}/{$file24}";

        $srcset = "{$publicUrl400} 400w, {$publicUrl800} 800w, {$publicUrl1600} 1600w";

        return [
            'path' => $publicUrl1600,
            'path_800' => $publicUrl800,
            'path_400' => $publicUrl400,
            'path_lqip' => $publicUrl24,
            'srcset' => $srcset,
            'lqip' => $lqipDataUri,
            'source_used' => $sourceUsed,
        ];
    }

    /**
     * Process an author portrait image to a square WebP.
     *
     * @return array{path: string, source_used: string}
     */
    public function processAuthorAvatar(string $sourceUrl, string $slug): array
    {
        $safeSlug = Str::slug($slug);
        $diskPublicPath = storage_path('app/public/authors');
        if (! file_exists($diskPublicPath)) {
            @mkdir($diskPublicPath, 0755, true);
        }

        [$binaryData, $sourceUsed] = $this->fetchImageDataWithFallbacks($sourceUrl, "author-{$safeSlug}", 'authors', 600, 600);

        $image = $this->manager->decode($binaryData);

        $filename = "{$safeSlug}-avatar.webp";
        $target = "{$diskPublicPath}/{$filename}";

        (clone $image)->cover(600, 600)->save($target, quality: 85);

        return [
            'path' => "/storage/authors/{$filename}",
            'source_used' => $sourceUsed,
        ];
    }

    /**
     * Fetch image binary with 3-tier fallback hierarchy:
     * 1. Manual seed-photos directory: storage/app/seed-photos/{category}/
     * 2. Curated Unsplash photo URL with retry (3 times, timeout 30s, SSL bypass for local dev)
     * 3. Picsum seed photo fallback: https://picsum.photos/seed/{slug}/{width}/{height}
     *
     * @return array{0: string, 1: string} [binaryData, sourceUsed]
     */
    protected function fetchImageDataWithFallbacks(string $sourceUrl, string $slug, string $category, int $width, int $height): array
    {
        // 1. Check manual seed-photos folder first
        $manualDir = storage_path("app/seed-photos/{$category}");
        if (is_dir($manualDir)) {
            $files = glob("{$manualDir}/*.{jpg,jpeg,png,webp,JPG,JPEG,PNG,WEBP}", GLOB_BRACE);
            if (! empty($files)) {
                // Check if a file matching the slug exists
                foreach ($files as $file) {
                    if (str_contains(basename($file), $slug)) {
                        return [(string) file_get_contents($file), 'manual'];
                    }
                }
                // Otherwise pick a file by hash
                $index = abs(crc32($slug)) % count($files);

                return [(string) file_get_contents($files[$index]), 'manual'];
            }
        }

        // If local file path was directly provided
        if (file_exists($sourceUrl) && ! is_dir($sourceUrl)) {
            return [(string) file_get_contents($sourceUrl), 'local_file'];
        }

        // 2. Download from Unsplash or provided HTTP URL
        if (str_starts_with($sourceUrl, 'http://') || str_starts_with($sourceUrl, 'https://')) {
            $binary = $this->downloadHttp($sourceUrl);
            if ($binary !== null) {
                return [$binary, 'unsplash'];
            }
        }

        // 3. Fallback to Picsum Photos (Guaranteed real photograph per slug)
        $picsumUrl = "https://picsum.photos/seed/{$slug}/{$width}/{$height}";
        $binary = $this->downloadHttp($picsumUrl);
        if ($binary !== null) {
            return [$binary, 'picsum'];
        }

        // 4. Secondary fallback: Generic Unsplash newsroom photo
        $fallbackUnsplash = "https://images.unsplash.com/photo-1585829365295-ab7cd400c167?auto=format&fit=crop&w={$width}&h={$height}&q=80";
        $binary = $this->downloadHttp($fallbackUnsplash);
        if ($binary !== null) {
            return [$binary, 'unsplash_fallback'];
        }

        // 5. Final safety fallback: clean photographic GD canvas without text
        return [$this->generateNeutralPhotographicBinary($width, $height), 'neutral_canvas'];
    }

    /**
     * Download binary via HTTP with 3 retries, 30s timeout, and SSL verification bypass.
     */
    protected function downloadHttp(string $url): ?string
    {
        for ($attempt = 1; $attempt <= 3; $attempt++) {
            try {
                $response = Http::withoutVerifying()
                    ->timeout(30)
                    ->withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
                        'Accept' => 'image/webp,image/avif,image/jpeg,image/*;q=0.9',
                    ])
                    ->get($url);

                if ($response->successful()) {
                    $body = $response->body();
                    // Validate that body is a valid image binary (> 1000 bytes)
                    if (strlen($body) > 1000) {
                        return $body;
                    }
                }
            } catch (\Throwable $e) {
                if ($attempt === 3) {
                    break;
                }
                usleep(400000 * $attempt); // 400ms, 800ms backoff
            }
        }

        return null;
    }

    /**
     * Clean neutral photographic tone gradient without ANY text, watermarks, or SVG badges.
     */
    protected function generateNeutralPhotographicBinary(int $width, int $height): string
    {
        $gd = imagecreatetruecolor($width, $height);

        // Warm dark editorial studio wash (pure tone, zero text)
        $topR = 24;
        $topG = 28;
        $topB = 36;
        $botR = 14;
        $botG = 17;
        $botB = 23;

        for ($y = 0; $y < $height; $y++) {
            $ratio = $y / $height;
            $r = (int) ($topR + ($botR - $topR) * $ratio);
            $g = (int) ($topG + ($botG - $topG) * $ratio);
            $b = (int) ($topB + ($botB - $topB) * $ratio);
            $color = imagecolorallocate($gd, $r, $g, $b);
            imageline($gd, 0, $y, $width, $y, $color);
        }

        ob_start();
        imagewebp($gd, null, 85);
        $binary = ob_get_clean();
        imagedestroy($gd);

        return (string) $binary;
    }
}
