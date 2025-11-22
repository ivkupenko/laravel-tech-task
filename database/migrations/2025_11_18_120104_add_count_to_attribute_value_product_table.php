<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attribute_value_product', function (Blueprint $table) {
            $table->integer('count')->after('attribute_value_id')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('attribute_value_product', function (Blueprint $table) {
            $table->dropColumn('count');
        });
    }
};
