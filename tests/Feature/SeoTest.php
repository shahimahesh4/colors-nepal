<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\PortfolioProject;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_include_canonical_and_social_metadata(): void
    {
        $this->get(route('home'))->assertOk()->assertSee('<link rel="canonical" href="'.route('home').'">', false)->assertSee('property="og:title"', false)->assertSee('name="twitter:card"', false)->assertSee('https://schema.org', false);
    }

    public function test_sitemap_contains_only_public_and_published_content(): void
    {
        $service = Service::factory()->create(['status' => 'published']);
        $project = PortfolioProject::factory()->create(['status' => 'published']);
        $post = BlogPost::factory()->create(['status' => 'published', 'published_at' => now()]);
        $draft = BlogPost::factory()->create(['status' => 'draft']);
        $this->get(route('sitemap'))->assertOk()->assertHeader('Content-Type', 'application/xml')->assertSee(route('services.show', $service), false)->assertSee(route('portfolio.show', $project), false)->assertSee(route('blog.show', $post), false)->assertDontSee(route('blog.show', $draft), false);
    }

    public function test_robots_file_protects_private_routes_and_links_sitemap(): void
    {
        $this->get(route('robots'))->assertOk()->assertSee('Disallow: /stnapanel')->assertSee('Disallow: /dashboard')->assertSee('Sitemap: '.route('sitemap'));
    }
}
