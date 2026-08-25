<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('site_settings')->updateOrInsert(
            ['key' => 'home_hero_image'],
            [
                'value' => 'settings/home-hero-default.png',
                'type' => 'image',
                'group' => 'home',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        );
        Cache::forget('site-settings');
    }

    public function down(): void
    {
        DB::table('site_settings')
            ->where('key', 'home_hero_image')
            ->where('value', 'settings/home-hero-default.png')
            ->update(['value' => null, 'updated_at' => now()]);
        Cache::forget('site-settings');
    }
};
