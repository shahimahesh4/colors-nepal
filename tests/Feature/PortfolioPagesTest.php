<?php

namespace Tests\Feature;

use App\Models\PortfolioCategory;
use App\Models\PortfolioProject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_portfolio_index_only_displays_published_projects(): void
    {
        $category = PortfolioCategory::factory()->create();

        PortfolioProject::factory()->create([
            'portfolio_category_id' => $category->id,
            'title' => 'Published Campaign',
            'status' => 'published',
        ]);

        PortfolioProject::factory()->create([
            'portfolio_category_id' => $category->id,
            'title' => 'Draft Campaign',
            'status' => 'draft',
        ]);

        $this->get(route('portfolio.index'))
            ->assertOk()
            ->assertSee('Published Campaign')
            ->assertDontSee('Draft Campaign');
    }

    public function test_portfolio_index_can_be_filtered_by_category(): void
    {
        $branding = PortfolioCategory::factory()->create(['name' => 'Branding', 'slug' => 'branding']);
        $web = PortfolioCategory::factory()->create(['name' => 'Web Design', 'slug' => 'web-design']);

        PortfolioProject::factory()->create([
            'portfolio_category_id' => $branding->id,
            'title' => 'Brand Identity',
            'status' => 'published',
        ]);

        PortfolioProject::factory()->create([
            'portfolio_category_id' => $web->id,
            'title' => 'Company Website',
            'status' => 'published',
        ]);

        $this->get(route('portfolio.index', ['category' => 'branding']))
            ->assertOk()
            ->assertSee('Brand Identity')
            ->assertDontSee('Company Website');

        $this->get(route('portfolio.index', ['category' => 'missing-category']))
            ->assertNotFound();
    }

    public function test_published_portfolio_project_detail_is_available(): void
    {
        $project = PortfolioProject::factory()->create([
            'title' => 'Digital Growth Platform',
            'slug' => 'digital-growth-platform',
            'status' => 'published',
            'client_name' => 'Niwax Studio',
            'technologies' => ['Laravel', 'Tailwind CSS'],
            'meta_title' => 'Digital Growth Platform Case Study',
            'meta_description' => 'A focused digital growth case study.',
            'meta_keywords' => 'digital growth, Laravel portfolio',
        ]);

        $this->get(route('portfolio.show', $project))
            ->assertOk()
            ->assertSee('Digital Growth Platform Case Study', false)
            ->assertSee('Niwax Studio')
            ->assertSee('Laravel')
            ->assertSee('Tailwind CSS')
            ->assertSee('digital growth, Laravel portfolio');
    }

    public function test_draft_portfolio_project_detail_returns_not_found(): void
    {
        $project = PortfolioProject::factory()->create([
            'status' => 'draft',
        ]);

        $this->get(route('portfolio.show', $project))
            ->assertNotFound();
    }
}
