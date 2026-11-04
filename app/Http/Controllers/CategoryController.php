<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    /**
     * Display category page with featured lead story, article grid and pagination.
     */
    public function show(Request $request, string $slug): Response
    {
        return $this->renderCategory($request, $slug);
    }

    /**
     * Display category page with localized route prefix.
     */
    public function showLocalized(Request $request, string $locale, string $slug): Response
    {
        if (in_array($locale, ['en', 'hi'])) {
            session(['locale' => $locale]);
            app()->setLocale($locale);
        }

        return $this->renderCategory($request, $slug);
    }

    protected function renderCategory(Request $request, string $slug): Response
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        // 1. Featured story in category
        $featuredStory = Article::published()
            ->where('category_id', $category->id)
            ->where('is_featured', true)
            ->with(['author:id,name,name_hi,slug,avatar,role_title,role_title_hi'])
            ->first();

        // Fallback to latest article if no featured
        if (! $featuredStory) {
            $featuredStory = Article::published()
                ->where('category_id', $category->id)
                ->with(['author:id,name,name_hi,slug,avatar,role_title,role_title_hi'])
                ->first();
        }

        $excludeIds = $featuredStory ? [$featuredStory->id] : [];

        // 2. Paginated grid of remaining stories (9 per page)
        $articles = Article::published()
            ->where('category_id', $category->id)
            ->whereNotIn('id', $excludeIds)
            ->with(['author:id,name,name_hi,slug,avatar'])
            ->paginate(9)
            ->withQueryString();

        return Inertia::render('Category/Show', [
            'category' => $category,
            'featuredStory' => $featuredStory,
            'articles' => $articles,
        ]);
    }
}
