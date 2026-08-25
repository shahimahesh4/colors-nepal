<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        foreach ([
            ['key' => 'home_hero_eyebrow', 'value' => 'Nepal-based digital agency', 'type' => 'text'],
            ['key' => 'home_hero_title', 'value' => 'Digital work built to move your business forward.', 'type' => 'text'],
            ['key' => 'home_hero_description', 'value' => 'We bring websites, marketing, SEO, hosting, and ongoing support into one clear, maintainable digital partnership.', 'type' => 'textarea'],
            ['key' => 'home_hero_primary_label', 'value' => 'Start a project', 'type' => 'text'],
            ['key' => 'home_hero_primary_url', 'value' => '/request-quote', 'type' => 'text'],
            ['key' => 'home_hero_secondary_label', 'value' => 'Explore our work', 'type' => 'text'],
            ['key' => 'home_hero_secondary_url', 'value' => '/portfolio', 'type' => 'text'],
            ['key' => 'home_hero_supporting_text', 'value' => 'Strategy, design, development, launch, and growth support.', 'type' => 'text'],
            ['key' => 'home_hero_image', 'value' => null, 'type' => 'image'],
            ['key' => 'home_hero_image_alt', 'value' => 'Colors Nepal digital services', 'type' => 'text'],
        ] as $setting) {
            DB::table('site_settings')->updateOrInsert(
                ['key' => $setting['key']],
                $setting + ['group' => 'home', 'created_at' => now(), 'updated_at' => now()],
            );
        }

        Cache::forget('site-settings');
    }

    public function down(): void
    {
        DB::table('site_settings')->whereIn('key', [
            'home_hero_eyebrow', 'home_hero_title', 'home_hero_description',
            'home_hero_primary_label', 'home_hero_primary_url',
            'home_hero_secondary_label', 'home_hero_secondary_url',
            'home_hero_supporting_text', 'home_hero_image', 'home_hero_image_alt',
        ])->delete();
        Cache::forget('site-settings');
    }
};
