<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\ServiceFaq;
use App\Models\ServiceFeature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServicePagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_service_index_displays_only_published_services(): void
    {
        Service::factory()->create(['title' => 'Published service', 'slug' => 'published-service', 'status' => 'published']);
        Service::factory()->create(['title' => 'Draft service', 'slug' => 'draft-service', 'status' => 'draft']);

        $this->get(route('services.index'))
            ->assertOk()
            ->assertSee('Published service')
            ->assertSee('service-card', false)
            ->assertSee('Learn more')
            ->assertDontSee('Draft service');
    }

    public function test_published_service_detail_displays_features_faqs_and_metadata(): void
    {
        $service = Service::factory()->create([
            'title' => 'SEO strategy',
            'slug' => 'seo-strategy',
            'status' => 'published',
            'meta_title' => 'SEO strategy for growing organizations',
            'meta_description' => 'A focused SEO service description.',
            'meta_keywords' => 'seo strategy, technical seo, Nepal',
        ]);
        ServiceFeature::factory()->for($service)->create(['title' => 'Technical review']);
        ServiceFaq::factory()->for($service)->create(['question' => 'How does the process begin?', 'answer' => 'It begins with a focused review.']);

        $this->get(route('services.show', $service))
            ->assertOk()
            ->assertSee('SEO strategy')
            ->assertSee('Technical review')
            ->assertSee('How does the process begin?')
            ->assertSee('It begins with a focused review.')
            ->assertSee('SEO strategy for growing organizations')
            ->assertSee('A focused SEO service description.')
            ->assertSee('seo strategy, technical seo, Nepal');
    }

    public function test_draft_service_detail_returns_not_found(): void
    {
        $service = Service::factory()->create(['slug' => 'private-draft', 'status' => 'draft']);

        $this->get('/services/private-draft')->assertNotFound();
    }
}
