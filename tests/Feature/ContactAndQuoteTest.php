<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\QuoteRequest;
use App\Notifications\LeadSubmitted;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ContactAndQuoteTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_page_is_available_and_valid_submission_is_stored(): void
    {
        Notification::fake();

        $this->get(route('contact.create'))->assertOk()->assertSee('Send message')->assertSee('hello@colorsnepal.com')->assertSee('+977 9800000000')->assertSee('Kathmandu, Nepal');

        $response = $this->post(route('contact.store'), [
            'name' => 'Asha Sharma',
            'email' => 'asha@example.com',
            'phone' => '+977 9800000000',
            'subject' => 'Website redesign',
            'message' => 'We need help redesigning our company website this quarter.',
        ]);

        $response->assertRedirect(route('contact.create'))->assertSessionHas('success');
        $this->assertDatabaseHas(ContactMessage::class, [
            'email' => 'asha@example.com',
            'subject' => 'Website redesign',
            'status' => 'new',
        ]);
        Notification::assertSentOnDemand(LeadSubmitted::class, function (LeadSubmitted $notification): bool {
            $mail = $notification->toMail((object) []);

            return $mail->view === 'emails.lead-submitted'
                && $mail->viewData['name'] === 'Asha Sharma'
                && $mail->viewData['contactEmail'] !== null;
        });
    }

    public function test_contact_submission_is_validated(): void
    {
        $this->post(route('contact.store'), [
            'name' => '',
            'email' => 'invalid',
            'subject' => '',
            'message' => 'short',
        ])->assertSessionHasErrors(['name', 'email', 'subject', 'message']);

        $this->assertDatabaseEmpty('contact_messages');
    }

    public function test_quote_page_is_available_and_valid_submission_is_stored(): void
    {
        Notification::fake();

        $this->get(route('quote.create'))->assertOk()->assertSee('Submit project request');

        $response = $this->post(route('quote.store'), [
            'name' => 'Bikash Rai',
            'email' => 'bikash@example.com',
            'company' => 'Himalayan Works',
            'services' => ['Website Design & Development', 'SEO'],
            'budget' => '50000-100000',
            'timeline' => '1-3 months',
            'message' => 'We need a new company website with a practical SEO foundation.',
            'consent' => '1',
        ]);

        $response->assertRedirect(route('quote.create'))->assertSessionHas('success');
        $quote = QuoteRequest::query()->where('email', 'bikash@example.com')->firstOrFail();

        $this->assertSame(['Website Design & Development', 'SEO'], $quote->services);
        $this->assertSame(5000000, $quote->budget_min);
        $this->assertSame(10000000, $quote->budget_max);
        $this->assertSame('new', $quote->status);
        Notification::assertSentOnDemand(LeadSubmitted::class);
    }

    public function test_quote_submission_rejects_unapproved_services(): void
    {
        $this->post(route('quote.store'), [
            'name' => 'Bikash Rai',
            'email' => 'bikash@example.com',
            'services' => ['Unknown service'],
            'budget' => 'not-sure',
            'timeline' => 'Flexible',
            'message' => 'We are exploring a project and need help defining the scope.',
            'consent' => '1',
        ])->assertSessionHasErrors(['services.0']);

        $this->assertDatabaseEmpty('quote_requests');
    }

    public function test_contact_submissions_are_rate_limited(): void
    {
        Notification::fake();

        $payload = [
            'name' => 'Rate Test',
            'email' => 'rate@example.com',
            'subject' => 'Rate limit test',
            'message' => 'This valid message is long enough for the validation rules.',
        ];

        for ($attempt = 1; $attempt <= 5; $attempt++) {
            $this->withServerVariables(['REMOTE_ADDR' => '198.51.100.20'])
                ->post(route('contact.store'), $payload)
                ->assertRedirect();
        }

        $this->withServerVariables(['REMOTE_ADDR' => '198.51.100.20'])
            ->post(route('contact.store'), $payload)
            ->assertTooManyRequests();
    }
}
