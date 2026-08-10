<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', fn (Blueprint $table) => $table->string('phone', 20)->nullable()->unique()->after('email'));

        foreach (['email_otp_enabled', 'phone_otp_enabled'] as $key) {
            DB::table('site_settings')->updateOrInsert(['key' => $key], [
                'value' => '0', 'type' => 'boolean', 'group' => 'authentication',
                'created_at' => now(), 'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('site_settings')->whereIn('key', ['email_otp_enabled', 'phone_otp_enabled'])->delete();
        Schema::table('users', fn (Blueprint $table) => $table->dropColumn('phone'));
    }
};
