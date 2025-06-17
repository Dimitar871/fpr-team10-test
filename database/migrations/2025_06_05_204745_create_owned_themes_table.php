<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('owned_themes', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('theme_id');
            $table->boolean('owned')->default(false);
            $table->boolean('equipped')->default(false);

            $table->primary(['user_id', 'theme_id']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('theme_id')->references('id')->on('themes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('owned_themes');
    }
};
