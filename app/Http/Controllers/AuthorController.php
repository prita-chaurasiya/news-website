<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Author;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AuthorController extends Controller
{
    /**
     * Display author profile with biography, metrics and bibliography.
     */
    public function show(Request $request, string $slug): Response
    {
        $author = Author::where('slug', $slug)->firstOrFail();

        $articles = Article::published()
            ->where('author_id', $author->id)
            ->with(['category:id,name,name_hi,slug,color'])
            ->paginate(9)
            ->withQueryString();

        $totalViews = Article::where('author_id', $author->id)->sum('views_count');
        $totalArticles = Article::where('author_id', $author->id)->count();

        return Inertia::render('Author/Show', [
            'author' => $author,
            'articles' => $articles,
            'stats' => [
                'total_articles' => $totalArticles,
                'total_views' => $totalViews,
            ],
        ]);
    }
}
