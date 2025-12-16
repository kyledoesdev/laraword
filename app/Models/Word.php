<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Word extends Model
{
    protected $fillable = ['word', 'is_target'];

    protected $casts = [
        'is_target' => 'boolean',
    ];

    public function dailyWords(): HasMany
    {
        return $this->hasMany(DailyWord::class);
    }

    public static function getRandomTarget(): self
    {
        return self::where('is_target', true)
            ->inRandomOrder()
            ->first();
    }

    public static function isValidWord(string $word): bool
    {
        return self::where('word', strtoupper($word))->exists();
    }
}