<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticlePageTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    /**
     * Test that an article page loads successfully.
     */
    public function test_article_page_loads_successfully(): void
    {
        $article = Article::first();
        $this->assertNotNull($article);

        $response = $this->get('/article/'.$article->slug);

        $response->assertStatus(200);
        $response->assertSee('Cabinet Clears');
    }

    /**
     * Test localized article URL sets locale.
     */
    public function test_localized_article_url_sets_locale(): void
    {
        $article = Article::first();
        $response = $this->get('/hi/article/'.$article->slug);

        $response->assertStatus(200);
        $this->assertEquals('hi', app()->getLocale());
    }

    /**
     * Test posting a comment to an article.
     */
    public function test_can_post_comment_to_article(): void
    {
        $article = Article::first();

        $response = $this->post('/article/'.$article->id.'/comments', [
            'author_name' => 'Test Reader',
            'author_email' => 'reader@example.com',
            'content' => 'An insightful perspective on infrastructure development.',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('comments', [
            'article_id' => $article->id,
            'author_name' => 'Test Reader',
        ]);
    }

    /**
     * Test liking a comment.
     */
    public function test_can_like_comment(): void
    {
        $comment = Comment::first();
        $this->assertNotNull($comment);
        $initialLikes = $comment->likes_count;

        $response = $this->postJson('/comments/'.$comment->id.'/like');

        $response->assertStatus(200);
        $response->assertJson([
            'likes_count' => $initialLikes + 1,
        ]);
    }

    /**
     * Test bookmarking an article as an authenticated user.
     */
    public function test_authenticated_user_can_bookmark_article(): void
    {
        $user = User::first();
        $article = Article::first();

        $response = $this->actingAs($user)->postJson('/article/'.$article->id.'/bookmark');

        $response->assertStatus(200);
        $response->assertJson(['is_bookmarked' => true]);
        $this->assertDatabaseHas('bookmarks', [
            'user_id' => $user->id,
            'article_id' => $article->id,
        ]);

        // Toggle off
        $response2 = $this->actingAs($user)->postJson('/article/'.$article->id.'/bookmark');
        $response2->assertJson(['is_bookmarked' => false]);
    }
}
