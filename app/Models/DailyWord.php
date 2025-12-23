<?php

namespace App\Models;

use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyWord extends Model
{
    protected $fillable = [
        'word_id',
        'date',
    ];

    public function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }

    public function word(): BelongsTo
    {
        return $this->belongsTo(Word::class, 'word_id', 'id');
    }


    public static function getToday(): ?self
    {        
        return self::query()
            ->whereDate('date', today()->inUserTimezone())
            ->first();
    }
}