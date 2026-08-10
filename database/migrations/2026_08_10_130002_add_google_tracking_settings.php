<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $settings = [
            ['key' => 'google_analytics_enabled', 'value' => '0', 'type' => 'boolean'],
            ['key' => 'google_analytics_id', 'value' => null, 'type' => 'text'],
            ['key' => 'google_tag_manager_enabled', 'value' => '0', 'type' => 'boolean'],
            ['key' => 'google_tag_manager_id', 'value' => null, 'type' => 'text'],
        ];

        foreach ($settings as $setting) {
            DB::table('site_settings')->updateOrInsert(['key' => $setting['key']], $setting + [
                'group' => 'analytics', 'created_at' => now(), 'updated_at' => now(),
            ]);
        }
        Cache::forget('site-settings');
    }

    public function down(): void
    {
        DB::table('site_settings')->whereIn('key', [
            'google_analytics_enabled', 'google_analytics_id',
            'google_tag_manager_enabled', 'google_tag_manager_id',
        ])->delete();
        Cache::forget('site-settings');
    }
};
