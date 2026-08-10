<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RecaptchaTest extends TestCase
{
    use RefreshDatabase;

    public function test_enabled_recaptcha_widget_is_rendered_and_failed_check_blocks_submission(): void
    {
        $this->enableRecaptcha();
        Http::fake(['www.google.com/recaptcha/*' => Http::response(['success' => false])]);

        $this->get(route('contact.create'))->assertOk()
            ->assertSee('class="g-recaptcha"', false)
            ->assertSee('data-sitekey="test-site-key"', false);

        $this->post(route('contact.store'), [
            'name' => 'Bot Test', 'email' => 'bot@example.com', 'subject' => 'Blocked message',
            'message' => 'This submission should be blocked by the captcha middleware.',
            'g-recaptcha-response' => 'invalid-token',
        ])->assertSessionHasErrors('g-recaptcha-response');

        $this->assertDatabaseEmpty('contact_messages');
    }

    public function test_successful_recaptcha_allows_submission(): void
    {
        $this->enableRecaptcha();
        Http::fake(['www.google.com/recaptcha/*' => Http::response(['success' => true])]);
        Notification::fake();

        $this->post(route('contact.store'), [
            'name' => 'Human Test', 'email' => 'human@example.com', 'subject' => 'Allowed message',
            'message' => 'This valid submission should pass the captcha middleware.',
            'g-recaptcha-response' => 'valid-token',
        ])->assertRedirect(route('contact.create'));

        $this->assertDatabaseHas('contact_messages', ['email' => 'human@example.com']);
    }

    private function enableRecaptcha(): void
    {
        foreach (['recaptcha_enabled' => '1', 'recaptcha_site_key' => 'test-site-key', 'recaptcha_secret_key' => 'test-secret-key'] as $key => $value) {
            SiteSetting::query()->where('key', $key)->firstOrFail()->update(['value' => $value]);
        }
    }
}
