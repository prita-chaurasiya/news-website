<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomepageTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    /**
     * Test that the homepage loads successfully with Inertia.
     */
    public function test_homepage_loads_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('THE CHRONICLE');
    }

    /**
     * Test that language switcher sets session.
     */
    public function test_language_switcher_sets_session(): void
    {
        $response = $this->get('/lang/hi');

        $response->assertSessionHas('locale', 'hi');
    }

    /**
     * Test that latest news pagination returns JSON for AJAX requests.
     */
    public function test_latest_news_ajax_pagination(): void
    {
        $response = $this->getJson('/?page=2');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'latestNews',
            'hasMoreLatest',
            'currentPage',
        ]);
    }
}
