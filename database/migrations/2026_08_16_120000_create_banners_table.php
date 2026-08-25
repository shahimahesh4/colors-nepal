<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table): void {
            $table->id();
            $table->string('page_key')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $settings = DB::table('site_settings')
            ->whereIn('key', [
                'home_hero_title', 'home_hero_description', 'home_hero_image',
                'home_hero_primary_label', 'home_hero_primary_url',
            ])
            ->pluck('value', 'key');

        DB::table('banners')->insert([
            'page_key' => 'home',
            'title' => $settings->get('home_hero_title') ?: 'Digital work built to move your business forward.',
            'description' => $settings->get('home_hero_description') ?: 'We bring websites, marketing, SEO, hosting, and ongoing support into one clear, maintainable digital partnership.',
            'image' => $settings->get('home_hero_image') ?: 'settings/home-hero-default.png',
            'button_text' => $settings->get('home_hero_primary_label') ?: 'Start a project',
            'button_url' => $settings->get('home_hero_primary_url') ?: '/request-quote',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
