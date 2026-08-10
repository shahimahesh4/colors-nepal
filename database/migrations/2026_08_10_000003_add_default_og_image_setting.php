<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('site_settings')->updateOrInsert(['key' => 'default_og_image'], [
            'value' => null,
            'type' => 'image',
            'group' => 'seo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Cache::forget('site-settings');
    }

    public function down(): void
    {
        DB::table('site_settings')->where('key', 'default_og_image')->delete();
        Cache::forget('site-settings');
    }
};
