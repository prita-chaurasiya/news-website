<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Author;
use App\Models\Gallery;
use App\Models\Video;
use App\Services\ImagePipelineService;
use Database\Seeders\CuratedPhotoLibrary;
use Illuminate\Console\Command;

class AssignImagesCommand extends Command
{
    protected $signature = 'images:assign {--force : Re-assign and download fresh images for all records}';

    protected $description = 'Assign and backfill real curated photographs to all existing articles, authors, videos, and photo galleries without deleting existing content or comments';

    public function handle(ImagePipelineService $pipeline): int
    {
        $this->info('🎨 Starting The Chronicle Real Image Assignment & Backfill...');
        $this->line('Updating articles, author portraits, videos, and photo stories with high-resolution photographs.');

        $counts = [
            'articles' => 0,
            'authors' => 0,
            'videos' => 0,
            'galleries' => 0,
            'unsplash' => 0,
            'picsum' => 0,
            'manual' => 0,
            'failed' => 0,
        ];

        // 1. Assign Real Images to All Articles
        $articles = Article::with('category')->get();
        $this->newLine();
        $this->info("📰 Assigning real images to {$articles->count()} existing articles...");
        $artBar = $this->output->createProgressBar($articles->count());
        $artBar->start();

        foreach ($articles as $index => $article) {
            $catSlug = $article->category?->slug ?? 'politics';
            $curated = CuratedPhotoLibrary::getForCategory($catSlug, $index);

            // Update caption and credit from curated library
            if (empty($article->image_caption) || str_contains($article->image_caption, 'Special investigative dispatch') || str_contains($article->image_caption, 'SPECIAL REPORT')) {
                $article->image_caption = $curated['caption'];
                $article->image_caption_hi = $curated['caption_hi'];
            }
            $article->image_credit = $curated['credit'] ?? 'Photo: Unsplash';

            try {
                $processed = $pipeline->processAndStore($curated['url'], $article->slug, 'articles');
                $article->featured_image = $processed['path'];
                $article->image_lqip = $processed['lqip'];
                $article->saveQuietly();

                $counts['articles']++;
                $counts[$processed['source_used']] = ($counts[$processed['source_used']] ?? 0) + 1;
            } catch (\Throwable $e) {
                $counts['failed']++;
            }

            $artBar->advance();
        }
        $artBar->finish();
        $this->newLine();

        // 2. Assign Real Portraits to All Authors (8 Distinct Editorial Portraits)
        $authors = Author::all();
        $this->newLine();
        $this->info("👤 Assigning high-resolution portraits to {$authors->count()} authors...");
        $authBar = $this->output->createProgressBar($authors->count());
        $authBar->start();

        foreach ($authors as $author) {
            $curatedAuthor = CuratedPhotoLibrary::$authors[$author->slug] ?? null;
            $sourceUrl = $curatedAuthor['photo'] ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&h=600&q=80';

            try {
                $processed = $pipeline->processAuthorAvatar($sourceUrl, $author->slug);
                $author->avatar = $processed['path'];
                $author->saveQuietly();

                $counts['authors']++;
                $counts[$processed['source_used']] = ($counts[$processed['source_used']] ?? 0) + 1;
            } catch (\Throwable $e) {
                $counts['failed']++;
            }

            $authBar->advance();
        }
        $authBar->finish();
        $this->newLine();

        // 3. Assign Real Thumbnails to All Videos
        $videos = Video::all();
        $this->newLine();
        $this->info("🎥 Assigning real thumbnails to {$videos->count()} videos...");
        $vidBar = $this->output->createProgressBar($videos->count());
        $vidBar->start();

        foreach ($videos as $index => $video) {
            $vidCurated = CuratedPhotoLibrary::getForCategory('tech', $index);

            try {
                $processed = $pipeline->processAndStore($vidCurated['url'], $video->slug, 'videos');
                $video->thumbnail = $processed['path'];
                $video->saveQuietly();

                $counts['videos']++;
                $counts[$processed['source_used']] = ($counts[$processed['source_used']] ?? 0) + 1;
            } catch (\Throwable $e) {
                $counts['failed']++;
            }

            $vidBar->advance();
        }
        $vidBar->finish();
        $this->newLine();

        // 4. Assign Real Covers and Photos to All Galleries
        $galleries = Gallery::all();
        $this->newLine();
        $this->info("🖼️ Assigning real photo stories to {$galleries->count()} galleries...");
        $galBar = $this->output->createProgressBar($galleries->count());
        $galBar->start();

        foreach ($galleries as $index => $gallery) {
            $galCurated = CuratedPhotoLibrary::getForCategory('lifestyle', $index);

            try {
                $processed = $pipeline->processAndStore($galCurated['url'], $gallery->slug, 'galleries');
                $gallery->cover_image = $processed['path'];

                $photos = [];
                for ($p = 0; $p < 4; $p++) {
                    $item = CuratedPhotoLibrary::getForCategory('india', $index * 4 + $p);
                    $photos[] = [
                        'url' => $item['url'],
                        'caption' => $item['caption'],
                        'credit' => $item['credit'] ?? 'Photo: Unsplash',
                    ];
                }
                $gallery->photos = $photos;
                $gallery->saveQuietly();

                $counts['galleries']++;
                $counts[$processed['source_used']] = ($counts[$processed['source_used']] ?? 0) + 1;
            } catch (\Throwable $e) {
                $counts['failed']++;
            }

            $galBar->advance();
        }
        $galBar->finish();
        $this->newLine(2);

        // Final Report
        $this->info('====================================================');
        $this->info('🎉 THE CHRONICLE IMAGES ASSIGNED & STORED LOCALLY');
        $this->info('====================================================');
        $this->line("Articles Updated    : {$counts['articles']}");
        $this->line("Authors Updated     : {$counts['authors']}");
        $this->line("Videos Updated      : {$counts['videos']}");
        $this->line("Galleries Updated   : {$counts['galleries']}");
        $this->line("Photos from Unsplash: {$counts['unsplash']}");
        $this->line("Photos from Picsum  : {$counts['picsum']}");
        $this->line("Photos from Manual  : {$counts['manual']}");
        $this->line("Failed              : {$counts['failed']}");
        $this->info('====================================================');

        return Command::SUCCESS;
    }
}
