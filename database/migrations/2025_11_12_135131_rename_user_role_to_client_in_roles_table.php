<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('roles')
            ->where('name', 'user')
            ->update(['name' => 'client']);
    }

    public function down(): void
    {
        DB::table('roles')
            ->where('name', 'client')
            ->update(['name' => 'user']);
    }
};

