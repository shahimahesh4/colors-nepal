<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        foreach ([
            ['key' => 'recaptcha_enabled', 'value' => '0', 'type' => 'boolean'],
            ['key' => 'recaptcha_site_key', 'value' => null, 'type' => 'text'],
            ['key' => 'recaptcha_secret_key', 'value' => null, 'type' => 'password'],
        ] as $setting) {
            DB::table('site_settings')->updateOrInsert(['key' => $setting['key']], $setting + ['group' => 'security', 'created_at' => now(), 'updated_at' => now()]);
        }
        Cache::forget('site-settings');
    }

    public function down(): void
    {
        DB::table('site_settings')->whereIn('key', ['recaptcha_enabled', 'recaptcha_site_key', 'recaptcha_secret_key'])->delete();
        Cache::forget('site-settings');
    }
};
