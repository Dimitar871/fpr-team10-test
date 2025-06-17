<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('main_color');
            $table->string('sub_color');
            $table->string('accent_color');
            $table->string('edit_color');
            $table->string('delete_color');
            $table->string('create_color');
            $table->string('background_color');
            $table->string('extra_color');
            $table->string('text_color');
            $table->integer('points');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('themes');
    }
};
