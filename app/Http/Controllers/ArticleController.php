<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Bookmark;
use App\Services\ArticleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ArticleController extends Controller
{
    public function __construct(
        protected ArticleService $articleService
    ) {}

    /**
     * Display the specified article with direct URL.
     */
    public function show(Request $request, string $slug): Response
    {
        return $this->renderArticle($request, $slug);
    }

    /**
     * Display the specified article with locale prefix in URL.
     */
    public function showLocalized(Request $request, string $locale, string $slug): Response
    {
        if (in_array($locale, ['en', 'hi'])) {
            session(['locale' => $locale]);
            app()->setLocale($locale);
        }

        return $this->renderArticle($request, $slug);
    }

    /**
     * Shared render method for article.
     */
    protected function renderArticle(Request $request, string $slug): Response
    {
        $article = $this->articleService->getArticleBySlug($slug);

        if (! $article) {
            abort(404, 'Article not found');
        }

        $relatedArticles = $this->articleService->getRelatedArticles($article, 4);
        $moreFromAuthor = $this->articleService->getMoreFromAuthor($article, 3);

        $isBookmarked = false;
        if ($user = $request->user()) {
            $isBookmarked = Bookmark::where('user_id', $user->id)
                ->where('article_id', $article->id)
                ->exists();
        }

        return Inertia::render('Article/Show', [
            'article' => $article,
            'relatedArticles' => $relatedArticles,
            'moreFromAuthor' => $moreFromAuthor,
            'isBookmarked' => $isBookmarked,
            'canonicalUrl' => url('/article/'.$article->slug),
        ]);
    }

    /**
     * Store a newly created comment or reply.
     */
    public function storeComment(Request $request, int $id): RedirectResponse|JsonResponse
    {
        $article = Article::findOrFail($id);

        $validated = $request->validate([
            'content' => ['required', 'string', 'min:3', 'max:2000'],
            'parent_id' => ['nullable', 'exists:comments,id'],
            'author_name' => ['nullable', 'string', 'max:100'],
            'author_email' => ['nullable', 'email', 'max:150'],
        ]);

        $this->articleService->addComment($article, $validated, $request->user());

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Comment posted successfully.']);
        }

        return redirect()->back()->with('success', 'Your comment has been published.');
    }

    /**
     * Like a comment.
     */
    public function likeComment(Request $request, int $commentId): JsonResponse
    {
        $likesCount = $this->articleService->likeComment($commentId);

        return response()->json([
            'likes_count' => $likesCount,
            'message' => 'Comment liked.',
        ]);
    }

    /**
     * Toggle bookmark for an article.
     */
    public function toggleBookmark(Request $request, int $id): JsonResponse
    {
        $user = $request->user();

        if (! $user) {
            return response()->json(['error' => 'Authentication required.'], 401);
        }

        $article = Article::findOrFail($id);
        $isBookmarked = $this->articleService->toggleBookmark($article, $user);

        return response()->json([
            'is_bookmarked' => $isBookmarked,
            'message' => $isBookmarked ? 'Article bookmarked.' : 'Bookmark removed.',
        ]);
    }
}
