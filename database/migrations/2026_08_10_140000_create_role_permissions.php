<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 20)->default('customer')->after('is_admin')->index();
        });

        DB::table('users')->where('is_admin', true)->update(['role' => 'admin']);

        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('role', 20)->unique();
            $table->json('permissions');
            $table->timestamps();
        });

        DB::table('role_permissions')->insert([
            ['role' => 'staff', 'permissions' => json_encode(config('role_permissions.defaults.staff', [])), 'created_at' => now(), 'updated_at' => now()],
            ['role' => 'customer', 'permissions' => json_encode(config('role_permissions.defaults.customer', [])), 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('role_permissions');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
