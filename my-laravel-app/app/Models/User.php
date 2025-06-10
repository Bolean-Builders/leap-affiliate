<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
    'name',
    'username',
    'email', 
    'password',
    'role',
    'user_type',
    'last_login_at',
    'last_login_ip',
];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is an affiliate
     */
    public function isAffiliate(): bool
    {
        return $this->role === 'affiliate' || $this->user_type === 'affiliate';
    }

    /**
     * Check if user is a vendor
     */
    public function isVendor(): bool
    {
        return $this->role === 'vendor' || $this->user_type === 'vendor';
    }

    /**
     * Update last login information
     */
    public function updateLastLogin(?string $ipAddress = null): void
    {
        $this->update([
            'last_login_at' => now(),
            'last_login_ip' => $ipAddress ?? request()->ip(),
        ]);
    }

    /**
     * Get the user's display name (prioritize username over name)
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->username ?? $this->name;
    }

    /**
     * Scope to filter by role
     */
    public function scopeRole($query, string $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Scope to filter by user type
     */
    public function scopeUserType($query, string $userType)
    {
        return $query->where('user_type', $userType);
    }

    /**
     * Scope to get affiliates only
     */
    public function scopeAffiliates($query)
    {
        return $query->where('role', 'affiliate');
    }

    /**
     * Scope to get vendors only
     */
    public function scopeVendors($query)
    {
        return $query->where('role', 'vendor');
    }

    /**
     * Scope to get recently active users
     */
    public function scopeRecentlyActive($query, int $days = 30)
    {
        return $query->where('last_login_at', '>=', now()->subDays($days));
    }
}