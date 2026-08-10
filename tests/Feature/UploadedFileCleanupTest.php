<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\PortfolioProject;
use App\Models\SiteSetting;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadedFileCleanupTest extends TestCase
{
    use RefreshDatabase;

    public function test_uploaded_files_are_deleted_with_their_records(): void
    {
        Storage::fake('public');

        $records = [
            BlogPost::query()->create(['title' => 'Post', 'slug' => 'post', 'excerpt' => 'Excerpt', 'content' => 'Content', 'featured_image' => 'blog/post.jpg']),
            PortfolioProject::query()->create(['title' => 'Project', 'slug' => 'project', 'summary' => 'Summary', 'cover_image' => 'portfolio/project.jpg']),
            TeamMember::query()->create(['name' => 'Member', 'slug' => 'member', 'role' => 'Developer', 'photo' => 'team/member.jpg']),
            Testimonial::query()->create(['name' => 'Client', 'content' => 'Excellent', 'avatar' => 'testimonials/client.jpg']),
            SiteSetting::query()->create(['key' => 'logo', 'value' => 'settings/logo.jpg', 'type' => 'image', 'group' => 'branding']),
        ];

        foreach (['blog/post.jpg', 'portfolio/project.jpg', 'team/member.jpg', 'testimonials/client.jpg', 'settings/logo.jpg'] as $path) {
            Storage::disk('public')->put($path, 'image');
        }

        foreach ($records as $record) {
            $record->delete();
        }

        Storage::disk('public')->assertMissing(['blog/post.jpg', 'portfolio/project.jpg', 'team/member.jpg', 'testimonials/client.jpg', 'settings/logo.jpg']);
    }

    public function test_replacing_an_upload_deletes_only_the_old_file(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('blog/old.jpg', 'old');
        Storage::disk('public')->put('blog/new.jpg', 'new');

        $post = BlogPost::query()->create(['title' => 'Post', 'slug' => 'post', 'excerpt' => 'Excerpt', 'content' => 'Content', 'featured_image' => 'blog/old.jpg']);
        $post->update(['featured_image' => 'blog/new.jpg']);

        Storage::disk('public')->assertMissing('blog/old.jpg');
        Storage::disk('public')->assertExists('blog/new.jpg');
    }

    public function test_deleting_a_text_setting_does_not_delete_a_file(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('settings/shared.txt', 'shared');

        SiteSetting::query()->create(['key' => 'notice', 'value' => 'settings/shared.txt', 'type' => 'text', 'group' => 'general'])->delete();

        Storage::disk('public')->assertExists('settings/shared.txt');
    }
}
