<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Banner;
use App\Models\PortfolioProject;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_hides_empty_or_unpublished_content_sections(): void
    {
        Service::factory()->create(['title' => 'Hidden draft service', 'status' => 'draft']);

        $this->get('/')
            ->assertOk()
            ->assertSee('Digital work built to move your business forward.')
            ->assertSee('Practical thinking before digital noise.')
            ->assertSee('A clear path from idea to improvement.')
            ->assertDontSee('Hidden draft service')
            ->assertDontSee('Selected work')
            ->assertDontSee('Client feedback')
            ->assertDontSee('Useful thinking for digital growth.');
    }

    public function test_homepage_displays_published_database_content(): void
    {
        Service::factory()->create(['title' => 'Published web service', 'status' => 'published']);
        PortfolioProject::factory()->create(['title' => 'Published project', 'status' => 'published']);
        Testimonial::factory()->create(['name' => 'Published client', 'content' => 'A genuine published review.', 'status' => 'published']);
        BlogPost::factory()->create(['title' => 'Published insight', 'status' => 'published', 'published_at' => now()]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Published web service')
            ->assertSee('Published project')
            ->assertSee('Published client')
            ->assertSee('A genuine published review.')
            ->assertSee('Published insight');
    }

    public function test_future_scheduled_posts_are_not_displayed(): void
    {
        BlogPost::factory()->create(['title' => 'Future insight', 'status' => 'published', 'published_at' => now()->addDay()]);

        $this->get('/')->assertDontSee('Future insight');
    }

    public function test_homepage_hero_uses_central_banner_record_and_default_illustration(): void
    {
        Banner::query()->where('page_key', 'home')->update([
            'title' => 'A dynamic homepage banner',
            'description' => 'Updated from Banner Management.',
            'image' => null,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('A dynamic homepage banner')
            ->assertSee('Updated from Banner Management.')
            ->assertSee('storage/settings/home-hero-default.png');
    }

    public function test_homepage_hero_serves_responsive_webp_with_intrinsic_dimensions(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('type="image/webp"', false)
            ->assertSee('home-hero-default-480.webp', false)
            ->assertSee('home-hero-default-768.webp', false)
            ->assertSee('width="1536"', false)
            ->assertSee('height="1024"', false)
            ->assertSee('fetchpriority="high"', false);
    }

    public function test_cached_header_services_are_refreshed_after_an_update(): void
    {
        $service = Service::factory()->create(['title' => 'Original service title', 'status' => 'published']);

        $this->get(route('contact.create'))->assertSee('Original service title');

        $service->update(['title' => 'Updated service title']);

        $this->get(route('contact.create'))
            ->assertSee('Updated service title')
            ->assertDontSee('Original service title');
    }

    public function test_homepage_hero_displays_the_uploaded_banner_image(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('banners/home/banner.webp', 'image');
        Banner::query()->where('page_key', 'home')->update(['image' => 'banners/home/banner.webp']);

        $this->get('/')
            ->assertOk()
            ->assertSee('storage/banners/home/banner.webp');
    }
}
