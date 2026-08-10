<?php

namespace Tests\Feature;

use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PageCmsTest extends TestCase
{
    use RefreshDatabase;

    public function test_published_page_is_rendered_by_livewire_with_metadata(): void
    {
        $page = Page::factory()->create([
            'title' => 'Privacy Policy',
            'slug' => 'privacy-policy',
            'content' => '<h2>Information we collect</h2><p>Policy content.</p>',
            'meta_title' => 'Privacy at Colors Nepal',
            'meta_description' => 'How Colors Nepal handles information.',
            'meta_keywords' => 'privacy, information',
        ]);

        $this->get(route('pages.show', $page))
            ->assertOk()
            ->assertSee('Privacy Policy')
            ->assertSee('Information we collect')
            ->assertSee('<title>Privacy at Colors Nepal | '.config('app.name').'</title>', false)
            ->assertSee('name="keywords" content="privacy, information"', false)
            ->assertSee('livewire/update', false);
    }

    public function test_draft_page_returns_not_found(): void
    {
        $page = Page::factory()->create(['slug' => 'draft-page', 'status' => 'draft']);

        $this->get(route('pages.show', $page))->assertNotFound();
    }

    public function test_existing_routes_take_priority_over_custom_page_slugs(): void
    {
        Page::factory()->create(['title' => 'Wrong About', 'slug' => 'about']);

        $this->get(route('about'))
            ->assertOk()
            ->assertDontSee('Wrong About');
    }

    public function test_pages_table_has_content_and_seo_columns(): void
    {
        $this->assertTrue(Schema::hasColumns('pages', [
            'title', 'slug', 'excerpt', 'content', 'status', 'meta_title', 'meta_description', 'meta_keywords',
        ]));
    }
}
