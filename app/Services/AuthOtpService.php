<?php

namespace App\Services;

use App\Models\SiteSetting;
use App\Notifications\AuthOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;

class AuthOtpService
{
    public function channels(): array
    {
        $settings = SiteSetting::values();

        return [
            'email' => $settings->get('email_otp_enabled') === '1',
            'phone' => $settings->get('phone_otp_enabled') === '1',
        ];
    }

    public function enabled(): bool
    {
        return in_array(true, $this->channels(), true);
    }

    public function issue(Request $request, string $channel, string $email, ?string $phone, array $payload): void
    {
        $channels = $this->channels();
        if (! ($channels[$channel] ?? false)) {
            throw ValidationException::withMessages(['otp_channel' => 'That verification method is not available.']);
        }
        if ($channel === 'phone' && blank($phone)) {
            throw ValidationException::withMessages(['otp_channel' => 'Add a phone number before using phone verification.']);
        }

        $code = (string) random_int(100000, 999999);
        $request->session()->put('auth_otp', [
            'hash' => hash('sha256', $code),
            'expires_at' => now()->addMinutes(10)->timestamp,
            'payload' => $payload,
        ]);

        if ($channel === 'email') {
            Notification::route('mail', $email)->notify(new AuthOtp($code));
        } else {
            $settings = SiteSetting::values();
            $template = $settings->get('sparrow_sms_template') ?: 'Your {{ site_name }} OTP is {{ otp }}.';
            $message = str_replace(
                ['{{ site_name }}', '{{ otp }}'],
                [$settings->get('site_name') ?: config('app.name'), $code],
                $template,
            );
            app(SparrowSms::class)->send($phone, $message);
        }
    }
}
