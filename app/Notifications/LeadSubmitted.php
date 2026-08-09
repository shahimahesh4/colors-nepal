<?php

namespace App\Notifications;

use App\Models\ContactMessage;
use App\Models\QuoteRequest;
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
        return (new MailMessage)
            ->subject($this->type.' from '.$this->name)
            ->greeting($this->type)
            ->line($this->name.' ('.$this->email.') submitted a new enquiry.')
            ->line($this->summary)
            ->action('Review in STNA Panel', $this->adminUrl);
    }
}
