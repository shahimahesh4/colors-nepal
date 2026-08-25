<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        foreach ([
            ['key' => 'maintenance_enabled', 'value' => '0', 'type' => 'boolean'],
            ['key' => 'maintenance_title', 'value' => 'We are currently under construction', 'type' => 'text'],
            ['key' => 'maintenance_message', 'value' => 'We are improving our website and will be back soon. Thank you for your patience.', 'type' => 'textarea'],
            ['key' => 'maintenance_show_contact', 'value' => '1', 'type' => 'boolean'],
        ] as $setting) {
            DB::table('site_settings')->updateOrInsert(
                ['key' => $setting['key']],
                $setting + ['group' => 'maintenance', 'created_at' => now(), 'updated_at' => now()],
            );
        }

        Cache::forget('site-settings');
    }

    public function down(): void
    {
        DB::table('site_settings')->whereIn('key', [
            'maintenance_enabled', 'maintenance_title', 'maintenance_message', 'maintenance_show_contact',
        ])->delete();
        Cache::forget('site-settings');
    }
};
