<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('image')->nullable()->after('icon');
            $table->string('og_image')->nullable()->after('meta_description');
        });
        Schema::table('blog_posts', fn (Blueprint $table) => $table->string('og_image')->nullable()->after('meta_description'));
        Schema::table('portfolio_projects', fn (Blueprint $table) => $table->string('og_image')->nullable()->after('meta_description'));
    }

    public function down(): void
    {
        Schema::table('services', fn (Blueprint $table) => $table->dropColumn(['image', 'og_image']));
        Schema::table('blog_posts', fn (Blueprint $table) => $table->dropColumn('og_image'));
        Schema::table('portfolio_projects', fn (Blueprint $table) => $table->dropColumn('og_image'));
    }
};
