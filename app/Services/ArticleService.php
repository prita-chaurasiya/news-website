<?php

namespace App\Services;

use App\Jobs\IncrementArticleViewCount;
use App\Models\Article;
use App\Models\Bookmark;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class ArticleService
{
    /**
     * Retrieve an article by slug or slug_hi with all eager loaded relations.
     */
    public function getArticleBySlug(string $slug): ?Article
    {
        $article = Article::published()
            ->where(function ($q) use ($slug) {
                $q->where('slug', $slug)
                    ->orWhere('slug_hi', $slug);
            })
            ->with([
                'category:id,name,name_hi,slug,color',
                'author:id,name,name_hi,slug,role_title,role_title_hi,bio,bio_hi,avatar,twitter_handle,email',
                'tags:id,name,name_hi,slug',
                'approvedComments' => function ($query) {
                    $query->with([
                        'user:id,name,avatar',
                        'replies.user:id,name,avatar',
                    ])->orderBy('created_at', 'desc');
                },
            ])
            ->first();

        if ($article) {
            // Dispatch queued job to increment view count without blocking request
            IncrementArticleViewCount::dispatch($article->id);
        }

        return $article;
    }

    /**
     * Get related articles from the same category.
     *
     * @return Collection<int, Article>
     */
    public function getRelatedArticles(Article $article, int $limit = 4): Collection
    {
        return Article::published()
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->with(['category:id,name,name_hi,slug,color', 'author:id,name,name_hi,slug,avatar'])
            ->take($limit)
            ->get();
    }

    /**
     * Get more stories by the same author.
     *
     * @return Collection<int, Article>
     */
    public function getMoreFromAuthor(Article $article, int $limit = 3): Collection
    {
        return Article::published()
            ->where('author_id', $article->author_id)
            ->where('id', '!=', $article->id)
            ->with(['category:id,name,name_hi,slug,color'])
            ->take($limit)
            ->get();
    }

    /**
     * Add a comment or reply to an article.
     */
    public function addComment(Article $article, array $data, ?User $user = null): Comment
    {
        return Comment::create([
            'article_id' => $article->id,
            'user_id' => $user?->id,
            'parent_id' => $data['parent_id'] ?? null,
            'author_name' => $user ? $user->name : ($data['author_name'] ?? 'Reader'),
            'author_email' => $user ? $user->email : ($data['author_email'] ?? null),
            'content' => $data['content'],
            'status' => 'approved',
            'likes_count' => 0,
        ]);
    }

    /**
     * Like a comment.
     */
    public function likeComment(int $commentId): int
    {
        $comment = Comment::findOrFail($commentId);
        $comment->increment('likes_count');

        return $comment->fresh()->likes_count;
    }

    /**
     * Toggle bookmark for an authenticated user.
     */
    public function toggleBookmark(Article $article, User $user): bool
    {
        $existing = Bookmark::where('user_id', $user->id)
            ->where('article_id', $article->id)
            ->first();

        if ($existing) {
            $existing->delete();

            return false;
        }

        Bookmark::create([
            'user_id' => $user->id,
            'article_id' => $article->id,
        ]);

        return true;
    }
}
