<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const CONTENT = [
        'service:' => ['table' => 'services', 'column' => 'image'],
        'blog:' => ['table' => 'blog_posts', 'column' => 'featured_image'],
        'portfolio:' => ['table' => 'portfolio_projects', 'column' => 'cover_image'],
        'page:' => ['table' => 'pages', 'column' => 'image'],
    ];

    public function up(): void
    {
        if (! Schema::hasTable('banners')) {
            return;
        }

        foreach (self::CONTENT as $prefix => $content) {
            if (! Schema::hasTable($content['table']) || ! Schema::hasColumn($content['table'], $content['column'])) {
                continue;
            }

            DB::table('banners')
                ->where('page_key', 'like', $prefix.'%')
                ->whereNotNull('image')
                ->orderBy('id')
                ->each(function (object $banner) use ($prefix, $content): void {
                    $id = filter_var(substr($banner->page_key, strlen($prefix)), FILTER_VALIDATE_INT);

                    if ($id !== false) {
                        DB::table($content['table'])
                            ->where('id', $id)
                            ->whereNull($content['column'])
                            ->update([$content['column'] => $banner->image]);
                    }
                });
        }
    }

    public function down(): void
    {
        foreach (self::CONTENT as $content) {
            if (Schema::hasTable($content['table']) && Schema::hasColumn($content['table'], $content['column'])) {
                DB::table($content['table'])
                    ->where($content['column'], 'like', 'banners/library/%')
                    ->update([$content['column'] => null]);
            }
        }
    }
};
