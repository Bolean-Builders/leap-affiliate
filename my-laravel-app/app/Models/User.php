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
        'referral_code',
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

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            // Only generate referral code for affiliates
            if ($user->role === 'affiliate') {
                $user->referral_code = self::generateReferralCode();
            }
        });
    }

    /**
     * Generate referral code for affiliates only
     */
    private static function generateReferralCode()
    {
        $prefix = 'REF-AffLA';
        
        // Get the last affiliate with a referral code
        $lastAffiliate = self::where('role', 'affiliate')
            ->where('referral_code', 'like', $prefix . '%')
            ->orderBy('referral_code', 'desc')
            ->first();

        if ($lastAffiliate) {
            // Extract the number from the last referral code
            $lastNumber = (int) substr($lastAffiliate->referral_code, strlen($prefix));
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        // Format with leading zeros (001, 002, etc.)
        return $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }
}