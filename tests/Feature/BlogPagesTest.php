<?php

namespace Tests\Feature;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_blog_index_only_displays_currently_published_posts(): void
    {
        $published = BlogPost::factory()->create(['title' => 'Published Insight']);
        BlogPost::factory()->create(['title' => 'Draft Insight', 'status' => 'draft']);
        BlogPost::factory()->create(['title' => 'Future Insight', 'published_at' => now()->addDay()]);

        $this->get(route('blog.index'))
            ->assertOk()
            ->assertSee($published->title)
            ->assertDontSee('Draft Insight')
            ->assertDontSee('Future Insight');
    }

    public function test_blog_index_can_be_filtered_by_category(): void
    {
        $seo = BlogCategory::factory()->create(['name' => 'SEO', 'slug' => 'seo']);
        $web = BlogCategory::factory()->create(['name' => 'Web', 'slug' => 'web']);

        BlogPost::factory()->create(['blog_category_id' => $seo->id, 'title' => 'Search Guide']);
        BlogPost::factory()->create(['blog_category_id' => $web->id, 'title' => 'Website Guide']);

        $this->get(route('blog.index', ['category' => 'seo']))
            ->assertOk()
            ->assertSee('Search Guide')
            ->assertDontSee('Website Guide');

        $this->get(route('blog.index', ['category' => 'missing']))
            ->assertNotFound();
    }

    public function test_published_blog_post_detail_includes_seo_and_article_schema(): void
    {
        $post = BlogPost::factory()->create([
            'title' => 'Digital Strategy Guide',
            'slug' => 'digital-strategy-guide',
            'meta_title' => 'Digital Strategy Guide for Nepal',
            'meta_description' => 'Practical digital strategy guidance.',
            'meta_keywords' => 'digital strategy, Nepal',
        ]);

        $this->get(route('blog.show', $post))
            ->assertOk()
            ->assertSee('Digital Strategy Guide for Nepal', false)
            ->assertSee('Practical digital strategy guidance.', false)
            ->assertSee('application/ld+json', false)
            ->assertSee('https://schema.org', false)
            ->assertSee('digital strategy, Nepal');
    }

    public function test_draft_and_future_blog_posts_return_not_found(): void
    {
        $draft = BlogPost::factory()->create(['status' => 'draft']);
        $future = BlogPost::factory()->create(['published_at' => now()->addDay()]);

        $this->get(route('blog.show', $draft))->assertNotFound();
        $this->get(route('blog.show', $future))->assertNotFound();
    }
}
