<?php

namespace App\Notifications;

use App\Models\SiteSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AuthOtp extends Notification
{
    use Queueable;

    public function __construct(public string $code) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $settings = SiteSetting::values();

        return (new MailMessage)->subject('Your sign-in verification code')
            ->view('emails.auth-otp', [
                'code' => $this->code,
                'siteName' => $settings->get('site_name') ?: config('app.name'),
                'logoUrl' => $settings->get('logo') ? asset('storage/'.$settings->get('logo')) : null,
                'contactEmail' => $settings->get('contact_email') ?: config('mail.from.address'),
            ]);
    }
}
