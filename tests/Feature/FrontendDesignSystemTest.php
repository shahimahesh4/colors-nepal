<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ViewErrorBag;
use Tests\TestCase;

class FrontendDesignSystemTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        view()->share('errors', new ViewErrorBag);
    }

    public function test_core_display_components_render_expected_markup(): void
    {
        $html = Blade::render(<<<'BLADE'
            <x-ui.button href="/contact">Contact us</x-ui.button>
            <x-ui.badge variant="success">Published</x-ui.badge>
            <x-ui.alert variant="info" title="Note">Helpful information</x-ui.alert>
            <x-ui.card interactive>Card content</x-ui.card>
            <x-ui.section-heading eyebrow="Services" title="What we do" />
        BLADE);

        $this->assertStringContainsString('href="/contact"', $html);
        $this->assertStringContainsString('Published', $html);
        $this->assertStringContainsString('role="status"', $html);
        $this->assertStringContainsString('Card content', $html);
        $this->assertStringContainsString('What we do', $html);
    }

    public function test_form_components_render_accessible_labels_and_controls(): void
    {
        $html = Blade::render(<<<'BLADE'
            <x-ui.input label="Email address" name="email" type="email" required />
            <x-ui.textarea label="Message" name="message" help="Tell us about your project." />
            <x-ui.select label="Service" name="service"><option>SEO</option></x-ui.select>
        BLADE);

        $this->assertStringContainsString('Email address', $html);
        $this->assertStringContainsString('name="email"', $html);
        $this->assertStringContainsString('name="message"', $html);
        $this->assertStringContainsString('message-help', $html);
        $this->assertStringContainsString('name="service"', $html);
    }
}
