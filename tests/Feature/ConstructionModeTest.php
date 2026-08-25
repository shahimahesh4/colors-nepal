<?php

namespace Tests\Feature;

use App\Http\Middleware\ShowConstructionPage;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class ConstructionModeTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_website_is_available_when_construction_mode_is_disabled(): void
    {
        $this->get(route('home'))->assertOk();
    }

    public function test_public_website_shows_the_configured_construction_page(): void
    {
        SiteSetting::query()->where('key', 'maintenance_enabled')->update(['value' => '1']);
        SiteSetting::query()->where('key', 'maintenance_title')->update(['value' => 'A better website is coming']);
        cache()->forget('site-settings');

        $this->get(route('home'))
            ->assertStatus(503)
            ->assertHeader('Retry-After', '3600')
            ->assertSee('A better website is coming')
            ->assertSee('noindex, nofollow', false);
    }

    public function test_admin_panel_remains_available_during_construction_mode(): void
    {
        SiteSetting::query()->where('key', 'maintenance_enabled')->update(['value' => '1']);
        cache()->forget('site-settings');

        $this->get('/stnapanel/login')->assertOk()->assertDontSee('We are currently under construction');
    }

    public function test_livewire_requests_are_not_replaced_by_the_construction_page(): void
    {
        SiteSetting::query()->where('key', 'maintenance_enabled')->update(['value' => '1']);
        cache()->forget('site-settings');

        $request = Request::create('/livewire/update', 'POST');
        $response = app(ShowConstructionPage::class)->handle(
            $request,
            fn () => response('livewire request continued'),
        );

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('livewire request continued', $response->getContent());
    }
}
