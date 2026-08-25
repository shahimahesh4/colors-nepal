<?php

namespace Tests\Feature;

use App\Models\Banner;
use App\Models\Page;
use App\Models\Service;
use App\Models\User;
use App\Services\BannerManager;
use Database\Seeders\BannerSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BannerManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_banner_management_and_home_editor(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->get('/stnapanel/banners')
            ->assertOk()
            ->assertSee('Banners');

        $this->get('/stnapanel/banners/home')
            ->assertOk()
            ->assertSee('Home Page Banner');
    }

    public function test_page_options_include_static_custom_and_service_pages_but_not_home(): void
    {
        $page = Page::factory()->create(['title' => 'Privacy']);
        $service = Service::factory()->create(['title' => 'SEO']);
        $manager = app(BannerManager::class);

        $this->assertSame('About', $manager->label('route:about'));
        $this->assertSame('Privacy', $manager->label('page:'.$page->getKey()));
        $this->assertSame('SEO', $manager->label('service:'.$service->getKey()));
        $this->assertSame('unknown', $manager->label('unknown'));
    }

    public function test_active_custom_page_banner_is_displayed_only_on_its_page(): void
    {
        $page = Page::factory()->create(['title' => 'Privacy', 'slug' => 'privacy']);
        Banner::query()->create([
            'page_key' => 'page:'.$page->getKey(),
            'title' => 'Private and protected',
            'description' => 'A custom banner description.',
            'is_active' => true,
        ]);

        $this->get(route('pages.show', $page))->assertOk()->assertSee('Private and protected')->assertSee('A custom banner description.');
        $this->get(route('about'))->assertOk()->assertDontSee('Private and protected');
    }

    public function test_inactive_or_missing_image_uses_page_defaults_and_default_image(): void
    {
        Storage::fake('public');
        $page = Page::factory()->create(['title' => 'Privacy', 'slug' => 'privacy', 'excerpt' => 'Default page description.']);
        Banner::query()->create([
            'page_key' => 'page:'.$page->getKey(),
            'title' => 'Hidden banner',
            'image' => 'banners/pages/missing.webp',
            'is_active' => false,
        ]);

        $this->get(route('pages.show', $page))
            ->assertOk()
            ->assertSee('Privacy')
            ->assertSee('Default page description.')
            ->assertSee('storage/settings/home-hero-default.png')
            ->assertDontSee('Hidden banner');
    }

    public function test_banner_seeder_assigns_topic_related_images(): void
    {
        $seo = Service::factory()->create(['title' => 'SEO Consulting', 'slug' => 'seo-consulting']);
        $hosting = Service::factory()->create(['title' => 'Cloud Hosting', 'slug' => 'cloud-hosting']);

        $this->seed(BannerSeeder::class);

        $this->assertDatabaseHas('banners', ['page_key' => 'route:about', 'image' => 'banners/library/agency-collaboration.png']);
        $this->assertDatabaseHas('banners', ['page_key' => 'service:'.$seo->getKey(), 'image' => 'banners/library/seo-growth.png']);
        $this->assertDatabaseHas('banners', ['page_key' => 'service:'.$hosting->getKey(), 'image' => 'banners/library/hosting-domain.png']);
    }

    public function test_related_banner_images_are_safe_shared_content_assets(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('banners/library/web-design.png', 'image');

        $service = Service::factory()->create(['image' => 'banners/library/web-design.png']);
        $service->update(['image' => 'services/replacement.png']);

        Storage::disk('public')->assertExists('banners/library/web-design.png');
    }
}
