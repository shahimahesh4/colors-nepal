<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Models\TeamMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AboutPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_about_page_uses_safe_default_content_and_hides_empty_team_section(): void
    {
        $this->get(route('about'))
            ->assertOk()
            ->assertSee('Digital capability with a practical point of view.')
            ->assertSee('Make digital work more useful.')
            ->assertSee('Capability that grows with you.')
            ->assertDontSee('The people behind the work.');
    }

    public function test_about_page_uses_editable_settings(): void
    {
        SiteSetting::factory()->create(['key' => 'about_intro', 'value' => 'Editable company introduction.']);
        SiteSetting::factory()->create(['key' => 'mission', 'value' => 'Editable mission statement.']);
        SiteSetting::factory()->create(['key' => 'vision', 'value' => 'Editable vision statement.']);

        $this->get(route('about'))
            ->assertSee('Editable company introduction.')
            ->assertSee('Editable mission statement.')
            ->assertSee('Editable vision statement.');
    }

    public function test_about_page_displays_only_published_team_members(): void
    {
        TeamMember::factory()->create(['name' => 'Published Member', 'status' => 'published']);
        TeamMember::factory()->create(['name' => 'Draft Member', 'status' => 'draft']);

        $this->get(route('about'))
            ->assertOk()
            ->assertSee('The people behind the work.')
            ->assertSee('Published Member')
            ->assertDontSee('Draft Member');
    }
}
