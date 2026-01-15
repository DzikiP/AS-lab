<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Role;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    protected $fillable = [
        'username',
        'password',
        'role_id',
        'created_by',
        'updated_by',
    ];

    protected $hidden = [
        'password',
    ];

    protected static function booted()
    {
        static::creating(function ($user) {
            if (Auth::check()) {
                $user->created_by = Auth::id();
                $user->updated_by = Auth::id();
            }
        });

        static::updating(function ($user) {
            if (Auth::check()) {
                $user->updated_by = Auth::id();
            }
        });
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function hasRole(string $role): bool
    {
        return $this->role?->name === $role;
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'client_id');
    }
}
