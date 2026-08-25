<?php

namespace Tests\Feature;

use App\Models\QuoteRequest;
use App\Notifications\LeadSubmitted;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class MailConfigurationTest extends TestCase
{
    use RefreshDatabase;

    public function test_quote_notification_can_use_the_global_recipient(): void
    {
        config([
            'mail.default' => 'array',
            'mail.to.address' => 'admin@example.com',
            'mail.to.name' => 'Colors Nepal',
        ]);

        $quote = QuoteRequest::factory()->create();

        Notification::route('mail', config('mail.to.address'))
            ->notify(LeadSubmitted::forQuote($quote));

        $this->assertSame('Colors Nepal', config('mail.to.name'));
    }
}
