<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WordleGame extends Model
{
    protected $fillable = [
        'user_id',
        'daily_word_id',
        'board_state',
        'current_row',
        'status',
        'attempts_used',
    ];

    protected $casts = [
        'board_state' => 'array',
        'current_row' => 'integer',
        'attempts_used' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function dailyWord(): BelongsTo
    {
        return $this->belongsTo(DailyWord::class);
    }

    public function isComplete(): bool
    {
        return in_array($this->status, ['won', 'lost']);
    }

    public static function getOrCreateForToday(int $userId): self
    {
        $dailyWord = DailyWord::getToday();
        $wordLength = strlen($dailyWord->word->word);

        return self::firstOrCreate(
            [
                'user_id' => $userId,
                'daily_word_id' => $dailyWord->id,
            ],
            [
                'board_state' => self::createEmptyBoard(6, $wordLength),
                'current_row' => 0,
                'status' => 'active',
                'attempts_used' => 0,
            ]
        );
    }

    public static function createEmptyBoard(int $rows, int $cols): array
    {
        return collect(range(0, $rows - 1))
            ->map(fn() => collect(range(0, $cols - 1))
                ->map(fn($position) => [
                    'letter' => '',
                    'status' => '',
                    'position' => $position,
                ])
                ->toArray()
            )
            ->toArray();
    }
}