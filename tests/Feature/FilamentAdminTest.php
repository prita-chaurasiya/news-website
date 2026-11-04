<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilamentAdminTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_guest_is_redirected_to_filament_login(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/admin/login');
    }

    public function test_admin_user_can_access_filament_dashboard(): void
    {
        $admin = User::where('email', 'admin@demo.com')->first();
        $this->assertNotNull($admin, 'Demo admin user should exist from seeder');

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('The Chronicle');
        $response->assertSee('Total Articles');
        $response->assertSee('Total Reader Views');
        $response->assertSee('Pending Comments');
    }

    public function test_regular_user_cannot_access_filament_dashboard(): void
    {
        $user = User::where('role', 'user')->first() ?? User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(403);
    }

    public function test_admin_can_access_articles_resource(): void
    {
        $admin = User::where('email', 'admin@demo.com')->first();

        $response = $this->actingAs($admin)->get('/admin/articles');

        $response->assertStatus(200);
        $response->assertSee('Articles');
    }

    public function test_admin_can_access_categories_resource(): void
    {
        $admin = User::where('email', 'admin@demo.com')->first();

        $response = $this->actingAs($admin)->get('/admin/categories');

        $response->assertStatus(200);
        $response->assertSee('Categories');
    }

    public function test_admin_can_access_authors_resource(): void
    {
        $admin = User::where('email', 'admin@demo.com')->first();

        $response = $this->actingAs($admin)->get('/admin/authors');

        $response->assertStatus(200);
        $response->assertSee('Authors');
    }

    public function test_admin_can_access_comments_resource(): void
    {
        $admin = User::where('email', 'admin@demo.com')->first();

        $response = $this->actingAs($admin)->get('/admin/comments');

        $response->assertStatus(200);
        $response->assertSee('Comments');
    }

    public function test_admin_can_access_videos_resource(): void
    {
        $admin = User::where('email', 'admin@demo.com')->first();

        $response = $this->actingAs($admin)->get('/admin/videos');

        $response->assertStatus(200);
        $response->assertSee('Videos');
    }

    public function test_admin_can_access_ads_resource(): void
    {
        $admin = User::where('email', 'admin@demo.com')->first();

        $response = $this->actingAs($admin)->get('/admin/ads');

        $response->assertStatus(200);
        $response->assertSee('Ads');
    }

    public function test_admin_can_access_create_article_page(): void
    {
        $admin = User::where('email', 'admin@demo.com')->first();

        $response = $this->actingAs($admin)->get('/admin/articles/create');

        $response->assertStatus(200);
        $response->assertSee('Headline (English)');
        $response->assertSee('English Content');
        $response->assertSee('Hindi Content (हिंदी)');
        $response->assertSee('SEO & Social');
    }

    public function test_admin_can_access_edit_article_page(): void
    {
        $admin = User::where('email', 'admin@demo.com')->first();
        $article = Article::first();
        $this->assertNotNull($article);

        $response = $this->actingAs($admin)->get("/admin/articles/{$article->id}/edit");

        $response->assertStatus(200);
        $response->assertSee('Edit Article');
        $response->assertSee(e($article->slug));
    }

    public function test_comment_moderation_status_update(): void
    {
        $comment = Comment::where('status', 'pending')->first();
        if (! $comment) {
            $comment = Comment::create([
                'article_id' => Article::first()->id,
                'author_name' => 'Test Reviewer',
                'author_email' => 'reviewer@example.com',
                'content' => 'This is a pending test comment awaiting review.',
                'status' => 'pending',
            ]);
        }

        $this->assertEquals('pending', $comment->status);

        $comment->update(['status' => 'approved']);
        $this->assertEquals('approved', $comment->fresh()->status);

        $comment->update(['status' => 'rejected']);
        $this->assertEquals('rejected', $comment->fresh()->status);
    }
}
