<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SearchController extends Controller
{
    /**
     * Search page with query, category, and date filtering.
     */
    public function index(Request $request): Response
    {
        $query = $request->input('q', '');
        $categorySlug = $request->input('category', '');
        $dateFilter = $request->input('date', 'all');

        $articlesQuery = Article::published()
            ->with(['category:id,name,name_hi,slug,color', 'author:id,name,name_hi,slug,avatar']);

        // Text Search
        if (! empty($query)) {
            $articlesQuery->search($query);
        }

        // Category Filter
        if (! empty($categorySlug) && $categorySlug !== 'all') {
            $articlesQuery->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // Date Range Filter
        if ($dateFilter === 'today') {
            $articlesQuery->whereDate('published_at', Carbon::today());
        } elseif ($dateFilter === 'week') {
            $articlesQuery->where('published_at', '>=', Carbon::now()->subDays(7));
        } elseif ($dateFilter === 'month') {
            $articlesQuery->where('published_at', '>=', Carbon::now()->subDays(30));
        }

        $articles = $articlesQuery->paginate(10)->withQueryString();
        $categories = Category::select(['id', 'name', 'name_hi', 'slug'])->get();

        return Inertia::render('Search/Index', [
            'query' => $query,
            'selectedCategory' => $categorySlug,
            'selectedDate' => $dateFilter,
            'articles' => $articles,
            'categories' => $categories,
            'totalResults' => $articles->total(),
        ]);
    }

    /**
     * Instant search suggestions API endpoint (debounced on client).
     */
    public function suggestions(Request $request): JsonResponse
    {
        $term = $request->input('q', '');

        if (mb_strlen($term) < 2) {
            return response()->json([]);
        }

        $results = Article::published()
            ->search($term)
            ->select(['id', 'title', 'title_hi', 'slug', 'category_id', 'featured_image'])
            ->with('category:id,name,name_hi,slug,color')
            ->take(5)
            ->get();

        return response()->json($results);
    }
}
