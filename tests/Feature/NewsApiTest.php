<?php
namespace Tests\Feature;

use App\Models\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsApiTest extends TestCase {

    use RefreshDatabase;

    public function test_list_news(): void {
        News::factory()->create(['title' => 'Hello World', 'published_at' => now()]);
        $res = $this->getJson('/api/news');
        $res->assertOk()->assertJsonFragment(['title' => 'Hello World']);
    }
}