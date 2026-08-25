<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const IMAGES = [
        'web-design',
        'seo-growth',
        'digital-marketing',
        'hosting-domain',
        'portfolio-projects',
        'agency-collaboration',
    ];

    public function up(): void
    {
        $this->replaceExtension('jpg', 'png');
    }

    public function down(): void
    {
        $this->replaceExtension('png', 'jpg');
    }

    private function replaceExtension(string $from, string $to): void
    {
        if (! Schema::hasTable('banners')) {
            return;
        }

        foreach (self::IMAGES as $image) {
            DB::table('banners')
                ->where('image', "banners/library/{$image}.{$from}")
                ->update(['image' => "banners/library/{$image}.{$to}"]);
        }
    }
};
