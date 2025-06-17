<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('diary_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->date('entry_date');
            $table->enum('mood', ['Poor', 'Below Average', 'Average', 'Good', 'Excellent']);
            $table->enum('energy', ['Poor', 'Below Average', 'Average', 'Good', 'Excellent']);
            $table->enum('stress', ['Poor', 'Below Average', 'Average', 'Good', 'Excellent']);
            $table->text('highlights');
            $table->text('challenges');
            $table->text('gratitude');
            $table->text('improvements');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('diary_entries');
    }
};
