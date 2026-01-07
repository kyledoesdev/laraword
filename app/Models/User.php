<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Kyledoesdev\Essentials\Concerns\HasStatsAfterEvents;

class User extends Authenticatable implements FilamentUser, HasAvatar, MustVerifyEmail
{
    use HasFactory;
    use HasStatsAfterEvents;
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'timezone',
        'ip_address',
        'user_agent',
        'user_platform',
        'user_packet',
        'email_verified_at',
        'remember_token',
        'is_dev',
    ];

    protected $hidden = [
        'remember_token',
        'ip_address',
        'user_agent',
        'user_platform',
        'user_packet',
        'password',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'user_packet' => 'object',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $user) {
            $user->timezone ??= timezone();
            $user->avatar = 'https://api.dicebear.com/7.x/identicon/svg?seed='.urlencode($user->name);
        });
    }

    public function connections()
    {
        return $this->hasMany(UserConnection::class);
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url;
    }

    public function getAvatarUrlAttribute(): ?string
    {
        if ($this->avatar && Str::isUrl($this->avatar)) {
            return $this->avatar;
        }

        if ($this->avatar && Storage::disk('public')->exists($this->avatar)) {
            return Storage::disk('public')->url($this->avatar);
        }

        return null;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $panel->getId() === 'admin' ? $this->is_dev : true;
    }
}
