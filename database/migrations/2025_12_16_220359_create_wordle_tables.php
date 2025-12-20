<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
         Schema::create('words', function (Blueprint $table) {
            $table->id();
            $table->string('word', 5)->unique();
            $table->boolean('is_target')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('is_target');
        });

        Schema::create('daily_words', function (Blueprint $table) {
            $table->id();
            $table->date('date')->unique();
            $table->foreignId('word_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('date');
        });

       Schema::create('wordle_games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('word_id')->nullable();
            $table->foreignId('daily_word_id')->nullable();
            $table->string('status');
            $table->unsignedTinyInteger('current_row')->default(0);
            $table->unsignedTinyInteger('attempts_used')->default(0);
            $table->json('board_state');
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
