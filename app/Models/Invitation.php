<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Invitation extends Model
{
    protected $fillable = [
        'email',
        'name',
        'token',
        'role',
        'invited_by',
        'accepted_at',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'accepted_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    public function invitedBy()
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    public function isExpired(): bool
    {
        return Carbon::now()->isAfter($this->expires_at);
    }

    public function isAccepted(): bool
    {
        return $this->accepted_at !== null;
    }

    public function getStatusAttribute(): string
    {
        if ($this->isAccepted()) {
            return 'diterima';
        }
        if ($this->isExpired()) {
            return 'kadaluarsa';
        }

        return 'menunggu';
    }
}
