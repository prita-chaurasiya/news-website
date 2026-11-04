<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BookmarkController extends Controller
{
    /**
     * Display the reader's saved / bookmarked articles.
     */
    public function index(Request $request): Response
    {
        $user = $request->user();
        $articlesQuery = Article::published()
            ->with(['category:id,name,name_hi,slug,color', 'author:id,name,name_hi,slug,avatar']);

        if ($user) {
            // Logged in: fetch from database bookmarks
            $articlesQuery->whereHas('bookmarks', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        } else {
            // Guest reader: fetch based on comma-separated IDs sent from client localStorage
            $ids = array_filter(explode(',', $request->query('ids', '')));
            if (! empty($ids)) {
                $articlesQuery->whereIn('id', $ids);
            } else {
                $articlesQuery->whereRaw('1 = 0'); // Empty initially until client hydrated
            }
        }

        $savedArticles = $articlesQuery->paginate(12)->withQueryString();

        return Inertia::render('Bookmarks/Index', [
            'savedArticles' => $savedArticles,
            'isGuest' => ! $user,
        ]);
    }
}
