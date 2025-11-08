<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('genders', function (Blueprint $table) {
            $table->unsignedTinyInteger('id')->primary();
            $table->string('gender');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('genders');
    }
};
