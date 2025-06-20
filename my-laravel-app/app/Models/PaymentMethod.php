<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class PaymentMethod extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'method_type',
        'method_name',
        'account_name',
        'account_number',
        'email',
        'bank_name',
        'bank_country',
        'account_details',
        'account_identifier',
        'currency',
        'country_code',
        'is_active',
        'is_default',
        'is_verified',
        'minimum_payout',
        'verification_status',
        'verification_notes',
        'verified_at',
        'verified_by',
        'last_used_at',
        'total_payouts',
        'total_amount',
    ];

    protected $casts = [
        'account_details' => 'array',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'is_verified' => 'boolean',
        'minimum_payout' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'verified_at' => 'datetime',
        'last_used_at' => 'datetime',
        'total_payouts' => 'integer',
    ];

    protected $dates = [
        'verified_at',
        'last_used_at',
        'deleted_at',
    ];

    // Constants for method types
    const METHOD_PAYPAL = 'paypal';
    const METHOD_BANK_TRANSFER = 'bank_transfer';
    const METHOD_MOBILE_MONEY = 'mobile_money';

    const METHOD_TYPES = [
        self::METHOD_PAYPAL => 'PayPal',
        self::METHOD_BANK_TRANSFER => 'Bank Transfer',
        self::METHOD_MOBILE_MONEY => 'Mobile Money',
    ];

    // Constants for verification status
    const STATUS_PENDING = 'pending';
    const STATUS_VERIFIED = 'verified';
    const STATUS_REJECTED = 'rejected';

    const VERIFICATION_STATUSES = [
        self::STATUS_PENDING => 'Pending',
        self::STATUS_VERIFIED => 'Verified',
        self::STATUS_REJECTED => 'Rejected',
    ];

    /**
     * Relationships
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Scopes
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeDefault(Builder $query): Builder
    {
        return $query->where('is_default', true);
    }

    public function scopeVerified(Builder $query): Builder
    {
        return $query->where('is_verified', true);
    }

    public function scopeByType(Builder $query, string $type): Builder
    {
        return $query->where('method_type', $type);
    }

    public function scopeByStatus(Builder $query, string $status): Builder
    {
        return $query->where('verification_status', $status);
    }

    public function scopeForPayout(Builder $query): Builder
    {
        return $query->where('is_active', true)
                    ->where('is_verified', true);
    }

    /**
     * Accessors & Mutators
     */
    public function getMethodTypeNameAttribute(): string
    {
        return self::METHOD_TYPES[$this->method_type] ?? ucfirst(str_replace('_', ' ', $this->method_type));
    }

    public function getVerificationStatusNameAttribute(): string
    {
        return self::VERIFICATION_STATUSES[$this->verification_status] ?? ucfirst($this->verification_status);
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->method_name ?: $this->getMethodTypeNameAttribute();
    }

    public function getFormattedMinimumPayoutAttribute(): string
    {
        return $this->currency . ' ' . number_format($this->minimum_payout, 2);
    }

    public function getFormattedTotalAmountAttribute(): string
    {
        return $this->currency . ' ' . number_format($this->total_amount, 2);
    }

    public function getIsEligibleForPayoutAttribute(): bool
    {
        return $this->is_active && $this->is_verified && $this->verification_status === self::STATUS_VERIFIED;
    }

    public function getPrimaryIdentifierAttribute(): string
    {
        if ($this->account_identifier) {
            return $this->account_identifier;
        }

        return match($this->method_type) {
            self::METHOD_PAYPAL => $this->email,
            self::METHOD_BANK_TRANSFER => $this->account_number,
            self::METHOD_MOBILE_MONEY => $this->account_number ?: $this->email,
            default => $this->account_number ?: $this->email
        };
    }

    /**
     * Helper Methods
     */
    public function markAsDefault(): bool
    {
        // Remove default from other methods of same type for this user
        static::where('user_id', $this->user_id)
              ->where('method_type', $this->method_type)
              ->where('id', '!=', $this->id)
              ->update(['is_default' => false]);

        return $this->update(['is_default' => true]);
    }

    public function markAsUsed(float $amount = null): bool
    {
        $data = [
            'last_used_at' => now(),
            'total_payouts' => $this->total_payouts + 1,
        ];

        if ($amount) {
            $data['total_amount'] = $this->total_amount + $amount;
        }

        return $this->update($data);
    }

    public function verify(User $verifier = null, string $notes = null): bool
    {
        return $this->update([
            'is_verified' => true,
            'verification_status' => self::STATUS_VERIFIED,
            'verified_at' => now(),
            'verified_by' => $verifier?->id,
            'verification_notes' => $notes,
        ]);
    }

    public function reject(string $notes = null, User $verifier = null): bool
    {
        return $this->update([
            'is_verified' => false,
            'verification_status' => self::STATUS_REJECTED,
            'verified_by' => $verifier?->id,
            'verification_notes' => $notes,
        ]);
    }

    public function activate(): bool
    {
        return $this->update(['is_active' => true]);
    }

    public function deactivate(): bool
    {
        return $this->update(['is_active' => false, 'is_default' => false]);
    }

    /**
     * Static Methods
     */
    public static function getMethodTypes(): array
    {
        return self::METHOD_TYPES;
    }

    public static function getVerificationStatuses(): array
    {
        return self::VERIFICATION_STATUSES;
    }

    /**
     * Boot method
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($paymentMethod) {
            // Auto-generate account identifier if not provided
            if (!$paymentMethod->account_identifier) {
                $paymentMethod->account_identifier = $paymentMethod->generateAccountIdentifier();
            }
        });

        static::updating(function ($paymentMethod) {
            // If setting as default, remove default from others
            if ($paymentMethod->isDirty('is_default') && $paymentMethod->is_default) {
                static::where('user_id', $paymentMethod->user_id)
                      ->where('method_type', $paymentMethod->method_type)
                      ->where('id', '!=', $paymentMethod->id)
                      ->update(['is_default' => false]);
            }
        });
    }

    /**
     * Generate account identifier for quick access
     */
    private function generateAccountIdentifier(): string
    {
        return match($this->method_type) {
            self::METHOD_PAYPAL => $this->email,
            self::METHOD_BANK_TRANSFER => $this->account_number ?: $this->bank_name,
            self::METHOD_MOBILE_MONEY => $this->account_number ?: $this->email,
            default => $this->account_number ?: $this->email ?: 'N/A'
        };
    }
}