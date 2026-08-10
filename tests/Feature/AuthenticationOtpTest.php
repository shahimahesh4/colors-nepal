<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Models\User;
use App\Notifications\AuthOtp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthenticationOtpTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_otp_protects_registration_when_enabled(): void
    {
        SiteSetting::query()->where('key', 'email_otp_enabled')->update(['value' => '1']);
        SiteSetting::query()->where('key', 'phone_otp_enabled')->update(['value' => '0']);
        SiteSetting::query()->first()?->touch();
        Notification::fake();

        $this->post(route('register'), [
            'name' => 'OTP Customer', 'email' => 'otp@example.com',
            'password' => 'password123', 'password_confirmation' => 'password123',
            'otp_channel' => 'email',
        ])->assertRedirect(route('otp.create'));

        $this->assertGuest();
        $this->assertDatabaseMissing('users', ['email' => 'otp@example.com']);
        $code = null;
        Notification::assertSentOnDemand(AuthOtp::class, function (AuthOtp $notification) use (&$code): bool {
            $code = $notification->code;
            return true;
        });

        $this->post(route('otp.verify'), ['code' => $code])->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'otp@example.com']);
    }

    public function test_phone_otp_uses_sparrow_sms_for_login(): void
    {
        SiteSetting::query()->where('key', 'phone_otp_enabled')->update(['value' => '1']);
        SiteSetting::query()->first()?->touch();
        SiteSetting::query()->where('key', 'sparrow_sms_endpoint')->update(['value' => 'https://api.sparrowsms.test/v2/sms/']);
        SiteSetting::query()->where('key', 'sparrow_sms_token')->update(['value' => 'token']);
        SiteSetting::query()->where('key', 'sparrow_sms_identity')->update(['value' => 'ColorsNepal']);
        SiteSetting::query()->where('key', 'sparrow_sms_template')->update(['value' => '{{ site_name }} code: {{ otp }}']);
        SiteSetting::query()->first()?->touch();
        Http::fake(['api.sparrowsms.test/*' => Http::response(['response_code' => 200, 'response' => 'queued'])]);
        $user = User::factory()->create(['phone' => '9800000000']);

        $this->post(route('login'), ['email' => $user->email, 'password' => 'password', 'otp_channel' => 'phone'])
            ->assertRedirect(route('otp.create'));
        $this->assertGuest();

        $code = null;
        Http::assertSent(function ($request) use (&$code): bool {
            preg_match('/\b(\d{6})\b/', $request['text'], $matches);
            $code = $matches[1] ?? null;
            return $request['to'] === '9800000000';
        });

        $this->post(route('otp.verify'), ['code' => $code])->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }
}
