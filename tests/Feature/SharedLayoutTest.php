<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Models\Service;
use App\Models\SocialLink;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SharedLayoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_uses_the_shared_accessible_layout(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('Skip to content')
            ->assertSee('Primary navigation')
            ->assertSee('Mobile navigation')
            ->assertSee('Get a quote')
            ->assertSee('All rights reserved.')
            ->assertSee('aria-current="page"', false)
            ->assertSee('livewire/update', false)
            ->assertSee('wire:navigate', false)
            ->assertDontSee('fonts.bunny.net');
    }

    public function test_mobile_menu_uses_native_html_without_a_javascript_dependency(): void
    {
        $this->get('/')
            ->assertSee('<details', false)
            ->assertSee('<summary', false)
            ->assertSee('Menu')
            ->assertSee('mobile-menu__panel', false);
    }

    public function test_footer_displays_configured_contact_and_social_links(): void
    {
        SiteSetting::query()->create(['key' => 'contact_email', 'value' => 'studio@example.com', 'type' => 'email', 'group' => 'contact']);
        SocialLink::query()->create(['name' => 'Facebook', 'icon' => 'facebook', 'url' => 'https://facebook.com/example', 'is_active' => true]);

        $this->get('/')
            ->assertOk()
            ->assertSee('studio@example.com')
            ->assertSee('https://facebook.com/example', false)
            ->assertSee('Facebook (opens in a new tab)');
    }
    public function test_service_dropdowns_only_display_published_services(): void
    {
        Service::factory()->create(['title' => 'Visible dropdown service', 'slug' => 'visible-dropdown-service', 'status' => 'published']);
        Service::factory()->create(['title' => 'Hidden dropdown service', 'slug' => 'hidden-dropdown-service', 'status' => 'draft']);

        $this->get('/')
            ->assertOk()
            ->assertSee('All Services')
            ->assertSee('Visible dropdown service')
            ->assertDontSee('Hidden dropdown service');
    }}
