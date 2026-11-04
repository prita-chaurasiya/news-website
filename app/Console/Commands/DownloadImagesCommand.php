<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Author;
use App\Models\Gallery;
use App\Models\Video;
use App\Services\ImagePipelineService;
use Database\Seeders\CuratedPhotoLibrary;
use Illuminate\Console\Command;

class DownloadImagesCommand extends Command
{
    protected $signature = 'images:download {--force : Force re-download even if already local}';

    protected $description = 'Download curated real photos, generate 3 WebP sizes (400, 800, 1600) + 24px blurred LQIP, and save locally into public storage';

    public function handle(ImagePipelineService $pipeline): int
    {
        $force = (bool) $this->option('force');

        $this->info('🎨 Starting The Chronicle High-Res Image Pipeline...');
        $this->line('Downloading real curated photographs: 3 WebP sizes (400w, 800w, 1600w) + 24px LQIP blur placeholder.');

        $counts = [
            'unsplash' => 0,
            'picsum' => 0,
            'manual' => 0,
            'other' => 0,
            'failed' => 0,
            'total' => 0,
        ];

        // 1. Process Articles
        $articles = Article::with('category')->get();
        $this->newLine();
        $this->info("📸 Processing {$articles->count()} editorial articles...");
        $bar = $this->output->createProgressBar($articles->count());
        $bar->start();

        foreach ($articles as $index => $article) {
            $counts['total']++;

            // If image is already downloaded and valid size (> 25KB), skip unless --force
            $currentPath = storage_path('app/public/articles/'.basename($article->featured_image ?? ''));
            $isPlaceholder = ! file_exists($currentPath) || filesize($currentPath) < 15000;

            if ($isPlaceholder || $force || empty($article->featured_image)) {
                $categorySlug = $article->category?->slug ?? 'politics';
                $curated = CuratedPhotoLibrary::getForCategory($categorySlug, $index);
                $sourceUrl = $curated['url'];

                // Update caption & credit if not already set or defaulted
                if (empty($article->image_caption) || str_contains($article->image_caption, 'Special investigative dispatch')) {
                    $article->image_caption = $curated['caption'];
                    $article->image_caption_hi = $curated['caption_hi'];
                }
                $article->image_credit = $curated['credit'] ?? 'Photo: Unsplash';

                try {
                    $processed = $pipeline->processAndStore($sourceUrl, $article->slug, 'articles');
                    $article->featured_image = $processed['path'];
                    $article->image_lqip = $processed['lqip'];
                    $article->saveQuietly();

                    $counts[$processed['source_used']] = ($counts[$processed['source_used']] ?? 0) + 1;
                } catch (\Throwable $e) {
                    $counts['failed']++;
                }
            } else {
                $counts['other']++;
            }

            $bar->advance();
        }
        $bar->finish();
        $this->newLine();

        // 2. Process Authors (8 Real High-Res Portraits)
        $authors = Author::all();
        $this->newLine();
        $this->info("👤 Processing {$authors->count()} journalist & columnist portrait avatars...");
        $authorBar = $this->output->createProgressBar($authors->count());
        $authorBar->start();

        foreach ($authors as $author) {
            $counts['total']++;

            $currentAvatar = storage_path('app/public/authors/'.basename($author->avatar ?? ''));
            $isPlaceholder = ! file_exists($currentAvatar) || filesize($currentAvatar) < 10000;

            if ($isPlaceholder || $force || empty($author->avatar)) {
                $curatedAuthor = CuratedPhotoLibrary::$authors[$author->slug] ?? null;
                $sourceUrl = $curatedAuthor['photo'] ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&h=600&q=80';

                try {
                    $processed = $pipeline->processAuthorAvatar($sourceUrl, $author->slug);
                    $author->avatar = $processed['path'];
                    $author->saveQuietly();

                    $counts[$processed['source_used']] = ($counts[$processed['source_used']] ?? 0) + 1;
                } catch (\Throwable $e) {
                    $counts['failed']++;
                }
            } else {
                $counts['other']++;
            }

            $authorBar->advance();
        }
        $authorBar->finish();
        $this->newLine();

        // 3. Process Videos
        $videos = Video::all();
        $this->newLine();
        $this->info("🎥 Processing {$videos->count()} video report thumbnails...");
        $videoBar = $this->output->createProgressBar($videos->count());
        $videoBar->start();

        foreach ($videos as $index => $video) {
            $counts['total']++;

            $currentThumb = storage_path('app/public/videos/'.basename($video->thumbnail ?? ''));
            $isPlaceholder = ! file_exists($currentThumb) || filesize($currentThumb) < 15000;

            if ($isPlaceholder || $force || empty($video->thumbnail)) {
                $videoCurated = CuratedPhotoLibrary::getForCategory('tech', $index);
                $sourceUrl = $videoCurated['url'];

                try {
                    $processed = $pipeline->processAndStore($sourceUrl, $video->slug, 'videos');
                    $video->thumbnail = $processed['path'];
                    $video->saveQuietly();

                    $counts[$processed['source_used']] = ($counts[$processed['source_used']] ?? 0) + 1;
                } catch (\Throwable $e) {
                    $counts['failed']++;
                }
            } else {
                $counts['other']++;
            }

            $videoBar->advance();
        }
        $videoBar->finish();
        $this->newLine();

        // 4. Process Galleries
        $galleries = Gallery::all();
        $this->info("Processing {$galleries->count()} photo stories...");
        $galleryBar = $this->output->createProgressBar($galleries->count());
        $galleryBar->start();

        foreach ($galleries as $index => $gallery) {
            $counts['total']++;

            $galleryCurated = CuratedPhotoLibrary::getForCategory('lifestyle', $index);
            $sourceUrl = $galleryCurated['url'];

            try {
                $processed = $pipeline->processAndStore($sourceUrl, $gallery->slug, 'galleries');
                $gallery->cover_image = $processed['path'];

                $galleryPhotos = [];
                for ($p = 0; $p < 4; $p++) {
                    $pCurated = CuratedPhotoLibrary::getForCategory('india', $index * 4 + $p);
                    $galleryPhotos[] = [
                        'url' => $pCurated['url'],
                        'caption' => $pCurated['caption'],
                        'credit' => $pCurated['credit'] ?? 'Photo: Unsplash',
                    ];
                }
                $gallery->photos = $galleryPhotos;
                $gallery->saveQuietly();

                $counts[$processed['source_used']] = ($counts[$processed['source_used']] ?? 0) + 1;
            } catch (\Throwable $e) {
                $counts['failed']++;
            }

            $galleryBar->advance();
        }
        $galleryBar->finish();
        $this->newLine(2);

        // Final Report
        $this->info('====================================================');
        $this->info('🎉 THE CHRONICLE IMAGE DOWNLOAD & PIPELINE REPORT');
        $this->info('====================================================');
        $this->line("Total Entities Processed : {$counts['total']}");
        $this->line("Downloaded from Unsplash : {$counts['unsplash']}");
        $this->line("Fell back to Picsum      : {$counts['picsum']}");
        $this->line("Loaded from Manual Folder: {$counts['manual']}");
        $this->line("Already Real / Cached    : {$counts['other']}");
        $this->line("Failed                   : {$counts['failed']}");
        $this->info('====================================================');

        return Command::SUCCESS;
    }
}
