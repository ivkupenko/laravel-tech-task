<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $roleId = DB::table('roles')->where('name', 'user')->value('id');
        if (!$roleId) {
            $roleId = DB::table('roles')->insertGetId([
                'name' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role_id')) {
                try {
                    $table->dropForeign(['role_id']);
                } catch (\Throwable $e) {

                }
            }
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->after('age')->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role_id')) {
                $table->dropForeign(['role_id']);
                $table->dropColumn('role_id');
            }
        });
    }
};
