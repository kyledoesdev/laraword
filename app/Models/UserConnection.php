<?php

namespace App\Models;

class UserConnection extends Model
{
    protected $fillable = [
        'user_id',
        'external_id',
        'type',
        'token',
        'refresh_token',
    ];

    protected $hidden = [
        'token',
        'refresh_token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
