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
         Schema::create('words', function (Blueprint $table) {
            $table->id();
            $table->string('word', 10)->unique();
            $table->boolean('is_target')->default(false);
            $table->timestamps();
            
            $table->index('is_target');
        });

        Schema::create('daily_words', function (Blueprint $table) {
            $table->id();
            $table->date('date')->unique();
            $table->foreignId('word_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            
            $table->index('date');
        });

       Schema::create('wordle_games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('daily_word_id')->constrained()->cascadeOnDelete();
            $table->json('board_state');
            $table->unsignedTinyInteger('current_row')->default(0);
            $table->enum('status', ['active', 'won', 'lost'])->default('active');
            $table->unsignedTinyInteger('attempts_used')->default(0);
            $table->timestamps();

            $table->unique(['user_id', 'daily_word_id']);
        });
    }
};
