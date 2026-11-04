<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Category;
use App\Models\Epaper;
use App\Models\Gallery;
use App\Models\MarketTicker;
use App\Models\Video;
use Illuminate\Support\Facades\Cache;

class HomeService
{
    /**
     * Fetch all homepage data with eager loading and 10-minute caching.
     *
     * @return array<string, mixed>
     */
    public function getHomepageData(int $page = 1): array
    {
        $locale = app()->getLocale();
        $cacheKey = "homepage_curated_data_v4_{$locale}";

        $curated = Cache::remember($cacheKey, 600, function () {
            // 1. Lead Story (Hero main)
            $leadStory = Article::published()
                ->where('is_featured', true)
                ->with(['category:id,name,name_hi,slug,color', 'author:id,name,name_hi,slug,avatar,role_title,role_title_hi'])
                ->first();

            $excludeIds = $leadStory ? [$leadStory->id] : [];

            // 2. Secondary Stories (Hero 4 grid)
            $secondaryStories = Article::published()
                ->where('is_featured', true)
                ->whereNotIn('id', $excludeIds)
                ->with(['category:id,name,name_hi,slug,color', 'author:id,name,name_hi,slug,avatar'])
                ->take(4)
                ->get();

            $excludeIds = array_merge($excludeIds, $secondaryStories->pluck('id')->toArray());

            // 3. Live Blog
            $liveBlog = Article::published()
                ->where('type', 'live')
                ->with(['category:id,name,name_hi,slug,color', 'author:id,name,name_hi,slug,avatar'])
                ->first();

            // 4. Breaking News Ticker (5 items)
            $breakingNews = Article::published()
                ->where('is_breaking', true)
                ->select(['id', 'title', 'title_hi', 'slug', 'slug_hi', 'published_at'])
                ->take(5)
                ->get();

            // 5. Trending Top 10 (Axios style)
            $trendingNews = Article::published()
                ->orderBy('views_count', 'desc')
                ->select(['id', 'title', 'title_hi', 'slug', 'slug_hi', 'views_count', 'category_id', 'reading_time'])
                ->with('category:id,name,name_hi,slug,color')
                ->take(10)
                ->get();

            // 6. Category Sections (Politics, Business, Tech, Sports, India, World)
            $selectedCategorySlugs = ['politics', 'business', 'tech', 'sports', 'india', 'world'];
            $categories = Category::whereIn('slug', $selectedCategorySlugs)->get();

            $categorySections = [];
            foreach ($categories as $cat) {
                $articles = Article::published()
                    ->where('category_id', $cat->id)
                    ->with(['author:id,name,name_hi,slug,avatar'])
                    ->take(4)
                    ->get();

                if ($articles->isNotEmpty()) {
                    $categorySections[] = [
                        'category' => [
                            'id' => $cat->id,
                            'name' => $cat->name,
                            'name_hi' => $cat->name_hi,
                            'slug' => $cat->slug,
                            'color' => $cat->color,
                        ],
                        'articles' => $articles->toArray(),
                    ];
                }
            }

            // 7. Opinion & Editorial (The Print style with author quotes)
            $opinionStories = Article::published()
                ->opinion()
                ->with(['author:id,name,name_hi,slug,avatar,role_title,role_title_hi'])
                ->take(6)
                ->get();

            // 8. Videos
            $videos = Video::orderBy('published_at', 'desc')->take(4)->get();

            // 9. Photo Galleries
            $galleries = Gallery::orderBy('published_at', 'desc')->take(2)->get();

            // 10. Epaper Latest
            $epaper = Epaper::orderBy('date', 'desc')->first();

            // 11. Market Tickers
            $marketTickers = MarketTicker::orderBy('sort_order', 'asc')->get()->toArray();

            return [
                'leadStory' => $leadStory ? $leadStory->toArray() : null,
                'secondaryStories' => $secondaryStories->toArray(),
                'liveBlog' => $liveBlog ? $liveBlog->toArray() : null,
                'breakingNews' => $breakingNews->toArray(),
                'trendingNews' => $trendingNews->toArray(),
                'categorySections' => $categorySections,
                'opinionStories' => $opinionStories->toArray(),
                'videos' => $videos->toArray(),
                'galleries' => $galleries->toArray(),
                'epaper' => $epaper ? $epaper->toArray() : null,
                'marketTickers' => $marketTickers,
            ];
        });

        // 12. Latest News with pagination support (8 per page)
        $latestNews = Article::published()
            ->with(['category:id,name,name_hi,slug,color', 'author:id,name,name_hi,slug,avatar'])
            ->paginate(8, ['*'], 'page', $page);

        return [
            ...$curated,
            'latestNews' => collect($latestNews->items())->toArray(),
            'hasMoreLatest' => $latestNews->hasMorePages(),
            'currentPage' => $latestNews->currentPage(),
        ];
    }
}
