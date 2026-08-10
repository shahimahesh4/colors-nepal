<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $settings = [
            ['key' => 'sparrow_sms_endpoint', 'value' => 'https://api.sparrowsms.com/v2/sms/', 'type' => 'url'],
            ['key' => 'sparrow_sms_identity', 'value' => null, 'type' => 'text'],
            ['key' => 'sparrow_sms_token', 'value' => null, 'type' => 'password'],
            ['key' => 'sparrow_sms_template', 'value' => 'Your {{ site_name }} OTP is {{ otp }}.', 'type' => 'textarea'],
        ];

        foreach ($settings as $setting) {
            DB::table('site_settings')->updateOrInsert(['key' => $setting['key']], $setting + [
                'group' => 'authentication', 'created_at' => now(), 'updated_at' => now(),
            ]);
        }

        Cache::forget('site-settings');
    }

    public function down(): void
    {
        DB::table('site_settings')->whereIn('key', [
            'sparrow_sms_endpoint', 'sparrow_sms_identity', 'sparrow_sms_token', 'sparrow_sms_template',
        ])->delete();
        Cache::forget('site-settings');
    }
};
