<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Model extends EloquentModel
{
    use HasFactory;
    use SoftDeletes;

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->inUserTimezone()->format('m/d/Y');
    }

    public function getUpdatedAtAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->inUserTimezone()->format('m/d/Y');
    }
}
