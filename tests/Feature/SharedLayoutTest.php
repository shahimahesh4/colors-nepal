<?php

namespace Tests\Feature;

use Tests\TestCase;

class SharedLayoutTest extends TestCase
{
    public function test_homepage_uses_the_shared_accessible_layout(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('Skip to content')
            ->assertSee('Primary navigation')
            ->assertSee('Mobile navigation')
            ->assertSee('Get a quote')
            ->assertSee('Discuss a project')
            ->assertSee('All rights reserved.')
            ->assertSee('aria-current="page"', false)
            ->assertDontSee('fonts.bunny.net');
    }

    public function test_mobile_menu_uses_native_html_without_a_javascript_dependency(): void
    {
        $this->get('/')
            ->assertSee('<details', false)
            ->assertSee('<summary', false)
            ->assertSee('Menu');
    }
}
