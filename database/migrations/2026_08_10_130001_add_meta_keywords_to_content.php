<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['services', 'blog_posts', 'portfolio_projects'] as $tableName) {
            Schema::table($tableName, fn (Blueprint $table) => $table->text('meta_keywords')->nullable()->after('meta_description'));
        }
    }

    public function down(): void
    {
        foreach (['services', 'blog_posts', 'portfolio_projects'] as $tableName) {
            Schema::table($tableName, fn (Blueprint $table) => $table->dropColumn('meta_keywords'));
        }
    }
};
