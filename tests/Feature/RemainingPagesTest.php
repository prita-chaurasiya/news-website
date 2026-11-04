<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RemainingPagesTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_category_page_loads(): void
    {
        $category = Category::first();
        $this->assertNotNull($category);

        $response = $this->get('/category/'.$category->slug);
        $response->assertStatus(200);
        $response->assertSee($category->name);
    }

    public function test_author_page_loads(): void
    {
        $author = Author::first();
        $this->assertNotNull($author);

        $response = $this->get('/author/'.$author->slug);
        $response->assertStatus(200);
        $response->assertSee($author->name);
    }

    public function test_search_page_and_suggestions_api(): void
    {
        $response = $this->get('/search?q=Cabinet');
        $response->assertStatus(200);

        $apiResponse = $this->getJson('/api/search/suggestions?q=Cabinet');
        $apiResponse->assertStatus(200);
        $this->assertIsArray($apiResponse->json());
    }

    public function test_static_pages_load(): void
    {
        $this->get('/about')->assertStatus(200);
        $this->get('/contact')->assertStatus(200);
        $this->get('/privacy')->assertStatus(200);
        $this->get('/terms')->assertStatus(200);
        $this->get('/advertise')->assertStatus(200);
        $this->get('/bookmarks')->assertStatus(200);
    }

    public function test_contact_form_submission(): void
    {
        $response = $this->post('/contact', [
            'name' => 'Aditi Rao',
            'email' => 'aditi@example.com',
            'department' => 'editorial',
            'subject' => 'Investigative Tip on Agrarian Subsidies',
            'message' => 'Please review the public tender records for rural solar installations.',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('contact_messages', [
            'email' => 'aditi@example.com',
            'subject' => 'Investigative Tip on Agrarian Subsidies',
        ]);
    }

    public function test_sitemaps_and_rss_feeds_return_xml(): void
    {
        $sitemap = $this->get('/sitemap.xml');
        $sitemap->assertStatus(200);
        $sitemap->assertHeader('Content-Type', 'application/xml; charset=utf-8');

        $newsSitemap = $this->get('/news-sitemap.xml');
        $newsSitemap->assertStatus(200);
        $newsSitemap->assertHeader('Content-Type', 'application/xml; charset=utf-8');

        $rss = $this->get('/feed');
        $rss->assertStatus(200);
        $rss->assertHeader('Content-Type', 'application/rss+xml; charset=utf-8');
    }
}
