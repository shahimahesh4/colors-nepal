<?php

namespace Tests\Feature;

use App\Filament\Pages\WebsiteSettings;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class WebsiteSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_the_unified_settings_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('filament.admin.pages.website-settings'))
            ->assertOk()
            ->assertSee('Website Settings')
            ->assertSee('Save website settings');
    }

    public function test_admin_can_save_settings_from_one_form(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        Livewire::actingAs($admin)
            ->test(WebsiteSettings::class)
            ->fillForm([
                'site_name' => 'Updated Colors Nepal',
                'default_currency' => 'NPR',
                'contact_email' => 'info@colorsnepal.com',
                'social_links' => [],
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('site_settings', ['key' => 'site_name', 'value' => 'Updated Colors Nepal']);
        $this->assertDatabaseHas('site_settings', ['key' => 'contact_email', 'value' => 'info@colorsnepal.com']);
    }

    public function test_customer_cannot_open_website_settings(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);

        $this->actingAs($customer)
            ->get(route('filament.admin.pages.website-settings'))
            ->assertForbidden();
    }
}
