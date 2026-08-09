<?php

namespace Tests\Feature;

use App\Models\DomainTld;
use App\Models\HostingPlan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HostingAndDomainsTest extends TestCase
{
    use RefreshDatabase;

    public function test_hosting_page_only_displays_published_plans_with_formatted_prices(): void
    {
        HostingPlan::factory()->create([
            'name' => 'Growth Hosting',
            'monthly_price' => 125000,
            'yearly_price' => 1250000,
            'status' => 'published',
        ]);
        HostingPlan::factory()->create([
            'name' => 'Internal Draft Hosting',
            'status' => 'draft',
        ]);

        $this->get(route('hosting.index'))
            ->assertOk()
            ->assertSee('Growth Hosting')
            ->assertSee('NPR 1,250')
            ->assertSee('NPR 12,500')
            ->assertDontSee('Internal Draft Hosting');
    }

    public function test_hosting_page_displays_featured_plan_first(): void
    {
        HostingPlan::factory()->create(['name' => 'Standard Plan', 'is_featured' => false, 'sort_order' => 1]);
        HostingPlan::factory()->create(['name' => 'Featured Plan', 'is_featured' => true, 'sort_order' => 10]);

        $this->get(route('hosting.index'))
            ->assertOk()
            ->assertSeeInOrder(['Featured Plan', 'Standard Plan']);
    }

    public function test_domains_page_only_displays_active_extensions_and_prices(): void
    {
        DomainTld::factory()->create([
            'extension' => '.com',
            'registration_price' => 150000,
            'renewal_price' => 180000,
            'is_active' => true,
        ]);
        DomainTld::factory()->create([
            'extension' => '.hidden',
            'is_active' => false,
        ]);

        $this->get(route('domains.index'))
            ->assertOk()
            ->assertSee('.com')
            ->assertSee('NPR 1,500')
            ->assertSee('NPR 1,800')
            ->assertDontSee('.hidden');
    }

    public function test_empty_product_pages_show_helpful_fallbacks(): void
    {
        $this->get(route('hosting.index'))
            ->assertOk()
            ->assertSee('Hosting plans are being prepared.');

        $this->get(route('domains.index'))
            ->assertOk()
            ->assertSee('Domain pricing is being prepared.');
    }
}
