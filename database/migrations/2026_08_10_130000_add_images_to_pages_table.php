<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            if (! Schema::hasColumn('pages', 'image')) {
                $table->string('image')->nullable()->after('content');
            }
            if (! Schema::hasColumn('pages', 'og_image')) {
                $table->string('og_image')->nullable()->after('meta_keywords');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $columns = array_values(array_filter(['image', 'og_image'], fn (string $column): bool => Schema::hasColumn('pages', $column)));
            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
