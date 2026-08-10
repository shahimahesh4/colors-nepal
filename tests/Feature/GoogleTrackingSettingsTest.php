<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GoogleTrackingSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_tracking_scripts_are_disabled_by_default(): void
    {
        $this->get(route('home'))->assertOk()
            ->assertDontSee('gtag/js', false)
            ->assertDontSee('gtm.js', false);
    }

    public function test_enabled_valid_google_ids_are_rendered(): void
    {
        $this->setSetting('google_analytics_id', 'G-ABC123XYZ');
        $this->setSetting('google_analytics_enabled', '1');
        $this->setSetting('google_tag_manager_id', 'GTM-ABC1234');
        $this->setSetting('google_tag_manager_enabled', '1');

        $this->get(route('home'))->assertOk()
            ->assertSee('gtag/js?id=G-ABC123XYZ', false)
            ->assertSee("gtag('config','G-ABC123XYZ')", false)
            ->assertSee("'dataLayer','GTM-ABC1234'", false)
            ->assertSee('ns.html?id=GTM-ABC1234', false);
    }

    private function setSetting(string $key, string $value): void
    {
        SiteSetting::query()->where('key', $key)->firstOrFail()->update(['value' => $value]);
    }
}
