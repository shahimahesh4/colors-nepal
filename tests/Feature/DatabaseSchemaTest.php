<?php

namespace Tests\Feature;

use App\Models\PortfolioCategory;
use App\Models\PortfolioProject;
use App\Models\Service;
use App\Models\ServiceFaq;
use App\Models\ServiceFeature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DatabaseSchemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_agency_tables_and_key_columns_exist(): void
    {
        $tables = [
            'site_settings', 'services', 'service_features', 'service_faqs',
            'portfolio_categories', 'portfolio_projects', 'testimonials',
            'team_members', 'blog_categories', 'blog_posts', 'contact_messages',
            'quote_requests', 'hosting_plans', 'domain_tlds', 'faqs',
        ];

        foreach ($tables as $table) {
            $this->assertTrue(Schema::hasTable($table), "Missing table: {$table}");
        }

        $this->assertTrue(Schema::hasColumns('users', ['is_admin']));
        $this->assertTrue(Schema::hasColumns('services', ['slug', 'status', 'sort_order', 'meta_title']));
        $this->assertTrue(Schema::hasColumns('quote_requests', ['user_id', 'assigned_to', 'budget_min', 'budget_max', 'currency']));
    }

    public function test_service_children_are_related_and_deleted_with_the_service(): void
    {
        $service = Service::factory()->create();
        ServiceFeature::factory()->for($service)->create();
        ServiceFaq::factory()->for($service)->create();

        $this->assertCount(1, $service->features);
        $this->assertCount(1, $service->faqs);

        $service->delete();

        $this->assertDatabaseCount('service_features', 0);
        $this->assertDatabaseCount('service_faqs', 0);
    }

    public function test_optional_portfolio_category_is_null_when_category_is_deleted(): void
    {
        $category = PortfolioCategory::factory()->create();
        $project = PortfolioProject::factory()->for($category, 'category')->create();

        $category->delete();

        $this->assertNull($project->fresh()->portfolio_category_id);
    }
}
