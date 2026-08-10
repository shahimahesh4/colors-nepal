<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Http;

class Recaptcha
{
    public function enabled(): bool
    {
        $settings = SiteSetting::values();
        return $settings->get('recaptcha_enabled') === '1'
            && filled($settings->get('recaptcha_site_key'))
            && filled($settings->get('recaptcha_secret_key'));
    }

    public function verify(?string $response, ?string $ip): bool
    {
        if (! $this->enabled()) {
            return true;
        }

        $result = Http::asForm()->timeout(10)->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => SiteSetting::values()->get('recaptcha_secret_key'),
            'response' => $response,
            'remoteip' => $ip,
        ]);

        return $result->successful() && $result->json('success') === true;
    }
}
