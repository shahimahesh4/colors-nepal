<?php

namespace App\Notifications;

use App\Models\ContactMessage;
use App\Models\QuoteRequest;
use App\Models\SiteSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LeadSubmitted extends Notification
{
    use Queueable;

    public function __construct(
        public string $type,
        public string $name,
        public string $email,
        public string $summary,
        public string $adminUrl,
    ) {}

    public static function forContact(ContactMessage $message): self
    {
        return new self(
            'New contact message',
            $message->name,
            $message->email,
            $message->subject,
            url('/stnapanel/contact-messages/'.$message->getKey().'/edit'),
        );
    }

    public static function forQuote(QuoteRequest $quote): self
    {
        return new self(
            'New quote request',
            $quote->name,
            $quote->email,
            implode(', ', $quote->services ?? []),
            url('/stnapanel/quote-requests/'.$quote->getKey().'/edit'),
        );
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $settings = SiteSetting::values();

        return (new MailMessage)
            ->subject($this->type.' from '.$this->name)
            ->view('emails.lead-submitted', [
                'type' => $this->type,
                'name' => $this->name,
                'email' => $this->email,
                'summary' => $this->summary,
                'adminUrl' => $this->adminUrl,
                'siteName' => $settings->get('site_name') ?: config('app.name'),
                'logoUrl' => $settings->get('logo') ? asset('storage/'.$settings->get('logo')) : null,
                'contactEmail' => $settings->get('contact_email') ?: config('mail.from.address'),
                'contactPhone' => $settings->get('contact_phone'),
                'contactAddress' => $settings->get('contact_address'),
            ]);
    }
}
