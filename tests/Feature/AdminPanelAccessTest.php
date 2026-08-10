<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPanelAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_admin_login(): void
    {
        $this->get('/stnapanel')->assertRedirect('/stnapanel/login');
    }

    public function test_regular_users_cannot_access_the_admin_panel(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/stnapanel')
            ->assertForbidden();
    }

    public function test_admin_users_can_access_the_admin_panel(): void
    {
        $this->actingAs(User::factory()->admin()->create())
            ->get('/stnapanel')
            ->assertOk();
    }

    public function test_admin_users_can_open_each_core_resource_list(): void
    {
        $this->actingAs(User::factory()->admin()->create());

        foreach (['pages', 'site-settings', 'services', 'portfolio-categories', 'portfolio-projects', 'testimonials', 'team-members', 'faqs', 'blog-categories', 'blog-posts', 'contact-messages', 'quote-requests', 'hosting-plans', 'domain-tlds', 'users'] as $resource) {
            $this->get("/stnapanel/{$resource}")->assertOk();
        }
    }
}
