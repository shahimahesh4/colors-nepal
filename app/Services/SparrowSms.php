<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class SparrowSms
{
    public function send(string $phone, string $message): void
    {
        $settings = SiteSetting::values();
        $endpoint = $settings->get('sparrow_sms_endpoint') ?: config('services.sparrow.url');
        $token = $settings->get('sparrow_sms_token') ?: config('services.sparrow.token');
        $identity = $settings->get('sparrow_sms_identity') ?: config('services.sparrow.from');

        if (blank($token) || blank($identity)) {
            throw new RuntimeException('Sparrow SMS token and identity are not configured.');
        }

        $response = Http::asForm()->timeout(10)->post($endpoint, [
            'token' => $token,
            'from' => $identity,
            'to' => preg_replace('/^\+977/', '', $phone),
            'text' => $message,
        ]);

        $response->throw();

        if ((int) $response->json('response_code') !== 200) {
            throw new RuntimeException($response->json('response', 'Sparrow SMS rejected the message.'));
        }
    }
}