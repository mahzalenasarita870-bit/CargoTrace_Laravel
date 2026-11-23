<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function hasRole(string|array $roles): bool
    {
        $userRole = strtolower((string) $this->role);
        $allowed = array_map('strtolower', is_array($roles) ? $roles : [$roles]);

        return in_array($userRole, $allowed, true);
    }

    public function isAdmin(): bool
    {
        return strtolower((string) $this->role) === 'admin';
    }

    public function isOperator(): bool
    {
        return strtolower((string) $this->role) === 'operator';
    }

    public function isCustomer(): bool
    {
        return strtolower((string) $this->role) === 'customer';
    }

    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class, 'customer_id');
    }

    public function appNotifications(): HasMany
    {
        return $this->hasMany(AppNotification::class);
    }
}