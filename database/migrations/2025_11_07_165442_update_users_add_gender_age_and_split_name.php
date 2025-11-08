<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedTinyInteger('gender_id')->after('email');
            $table->unsignedTinyInteger('age')->after('gender_id');


            $table->foreign('gender_id')->references('id')->on('genders');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['gender_id']);
            $table->dropColumn(['gender', 'age']);
        });
    }
};
