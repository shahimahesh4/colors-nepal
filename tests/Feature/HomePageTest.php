<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\PortfolioProject;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
