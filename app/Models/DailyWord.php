<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyWord extends Model
{
    protected $fillable = ['date', 'word_id'];

    protected $casts = [
        'date' => 'date',
    ];

    public function word(): BelongsTo
    {
        return $this->belongsTo(Word::class);
    }

    public static function getToday(): self
    {
        $today = Carbon::today();
        
        return self::with('word')
            ->whereDate('date', $today)
            ->firstOr(function () use ($today) {
                $word = Word::getRandomTarget();
                
                return self::create([
                    'date' => $today,
                    'word_id' => $word->id,
                ]);
            });
    }
}