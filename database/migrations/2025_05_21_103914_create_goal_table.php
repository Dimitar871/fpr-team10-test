<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();
            $table->text('specific')->nullable();
            $table->text('measureable')->nullable();
            $table->integer('achievable')->nullable();
            $table->enum('relevance', ['Work', 'Personal', 'Education', 'Physical/mental health', 'Other']);
            $table->date('time_based')->nullable();
            $table->boolean('achieved')->nullable();
            $table->date('achieved_by')->nullable()->default(NULL);
            $table->string('user_id')->nullable();
            $table->integer('progress')->nullable();
            $table->timestamps();
            $table->enum('goal_type', ['individual', 'team']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('goals');
    }
};
