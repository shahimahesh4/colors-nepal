<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Blade;
use Tests\TestCase;

class BrandingSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_upload_urls_are_same_origin(): void
    {
        $this->assertSame('/storage', config('filesystems.disks.public.url'));
    }

    public function test_logo_favicon_and_default_seo_settings_are_rendered(): void
    {
        foreach ([
            ['key' => 'site_name', 'value' => 'Demo Agency', 'type' => 'text', 'group' => 'general'],
            ['key' => 'logo', 'value' => 'settings/logo.png', 'type' => 'image', 'group' => 'branding'],
            ['key' => 'favicon', 'value' => 'settings/favicon.png', 'type' => 'image', 'group' => 'branding'],
            ['key' => 'default_meta_title', 'value' => 'Demo Agency Digital Services', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'default_meta_description', 'value' => 'Default agency description.', 'type' => 'textarea', 'group' => 'seo'],
            ['key' => 'default_meta_keywords', 'value' => 'web design, seo, nepal', 'type' => 'text', 'group' => 'seo'],
        ] as $setting) {
            SiteSetting::query()->create($setting);
        }

        SiteSetting::query()->where('key', 'mobile_logo')->firstOrFail()->update(['value' => 'settings/mobile-logo.png']);

        $html = Blade::render('<x-layouts.app>Page content</x-layouts.app>');

        $this->assertStringContainsString('<title>Demo Agency Digital Services</title>', $html);
        $this->assertStringContainsString('content="Default agency description."', $html);
        $this->assertStringContainsString('name="keywords" content="web design, seo, nepal"', $html);
        $this->assertStringContainsString('href="'.asset('storage/settings/favicon.png').'"', $html);
        $this->assertStringContainsString('rel="apple-touch-icon" sizes="180x180" href="'.asset('storage/settings/favicon.png').'"', $html);
        $this->assertStringContainsString('src="'.asset('storage/settings/logo.png').'"', $html);
        $this->assertStringContainsString(asset('storage/settings/mobile-logo.png'), $html);
        $this->assertStringContainsString('"logo":"'.asset('storage/settings/logo.png').'"', $html);
    }

    public function test_page_metadata_overrides_defaults(): void
    {
        SiteSetting::query()->create(['key' => 'default_meta_description', 'value' => 'Default description.', 'type' => 'textarea', 'group' => 'seo']);

        $html = Blade::render('<x-layouts.app title="Page title" description="Page description">Content</x-layouts.app>');

        $this->assertStringContainsString('<title>Page title | '.config('app.name').'</title>', $html);
        $this->assertStringContainsString('content="Page description"', $html);
        $this->assertStringNotContainsString('content="Default description."', $html);
    }
}
