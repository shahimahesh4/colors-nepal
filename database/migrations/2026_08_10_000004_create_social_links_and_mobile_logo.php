<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('icon', 30);
            $table->string('url');
            $table->boolean('is_active')->default(true)->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        foreach (['facebook', 'instagram', 'linkedin', 'youtube'] as $index => $platform) {
            $url = DB::table('site_settings')->where('key', $platform.'_url')->value('value');
            if ($url) {
                DB::table('social_links')->insert(['name' => ucfirst($platform), 'icon' => $platform, 'url' => $url, 'is_active' => true, 'sort_order' => $index + 1, 'created_at' => now(), 'updated_at' => now()]);
            }
        }

        DB::table('site_settings')->updateOrInsert(['key' => 'mobile_logo'], ['value' => null, 'type' => 'image', 'group' => 'branding', 'created_at' => now(), 'updated_at' => now()]);
        Cache::forget('site-settings');
    }

    public function down(): void
    {
        Schema::dropIfExists('social_links');
        DB::table('site_settings')->where('key', 'mobile_logo')->delete();
        Cache::forget('site-settings');
    }
};
