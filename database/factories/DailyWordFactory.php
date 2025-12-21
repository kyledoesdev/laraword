<?php

namespace Database\Factories;

use App\Models\DailyWord;
use App\Models\Word;
use Illuminate\Database\Eloquent\Factories\Factory;

class DailyWordFactory extends Factory
{
    protected $model = DailyWord::class;

    public function definition(): array
    {
        $word = Word::query()
            ->where('is_target', true)
            ->inRandomOrder()
            ->first();

        return [
            'word_id' => !is_null($word) ? $word->getKey() : Word::factory(),
            'date' => $this->faker->unique()->dateTimeBetween('-60 days', 'now'),
        ];
    }

    public function forDate(string $date): static
    {
        return $this->state(fn () => [
            'date' => $date,
        ]);
    }
}