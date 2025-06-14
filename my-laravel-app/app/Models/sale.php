<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_reference',
        'product_id',
        'affiliate_id',
        'vendor_id',
        'customer_email',
        'customer_name',
        'sale_amount',
        'commission_rate',
        'commission_amount',
        'status',
        'payment_status',
        'referral_code_used',
        'ip_address',
        'user_agent',
        'source_url',
        'currency',
        'exchange_rate',
        'processing_fee',
        'net_sale_amount',
        'sale_date',
        'confirmed_at'
    ];

    protected $casts = [
        'sale_amount' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'exchange_rate' => 'decimal:6',
        'processing_fee' => 'decimal:2',
        'net_sale_amount' => 'decimal:2',
        'sale_date' => 'datetime',
        'confirmed_at' => 'datetime',
    ];

    // Relationships
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(User::class, 'affiliate_id')
                    ->where('role', 'affiliate');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vendor_id')
                    ->where('role', 'vendor');
    }

    // Scopes
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed(Builder $query): Builder
    {
        return $query->where('status', 'confirmed');
    }

    public function scopePaid(Builder $query): Builder
    {
        return $query->where('payment_status', 'paid');
    }

    public function scopeByAffiliate(Builder $query, $affiliateId): Builder
    {
        return $query->where('affiliate_id', $affiliateId);
    }

    public function scopeByVendor(Builder $query, $vendorId): Builder
    {
        return $query->where('vendor_id', $vendorId);
    }

    public function scopeThisMonth(Builder $query): Builder
    {
        return $query->whereMonth('sale_date', now()->month)
                    ->whereYear('sale_date', now()->year);
    }

    public function scopeLastMonth(Builder $query): Builder
    {
        $lastMonth = now()->subMonth();
        return $query->whereMonth('sale_date', $lastMonth->month)
                    ->whereYear('sale_date', $lastMonth->year);
    }

    // Model Events for Role Validation
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sale) {
            $sale->validateUserRoles();
            $sale->generateSaleReference();
            $sale->calculateNetAmount();
        });

        static::updating(function ($sale) {
            $sale->validateUserRoles();
            $sale->calculateNetAmount();
        });
    }

    // Helper Methods
    public function validateUserRoles(): void
    {
        // Validate affiliate role
        $affiliate = User::find($this->affiliate_id);
        if (!$affiliate || $affiliate->role !== 'affiliate') {
            throw new \InvalidArgumentException('Affiliate ID must reference a user with affiliate role');
        }

        // Validate vendor role
        $vendor = User::find($this->vendor_id);
        if (!$vendor || $vendor->role !== 'vendor') {
            throw new \InvalidArgumentException('Vendor ID must reference a user with vendor role');
        }
    }

    public function generateSaleReference(): void
    {
        if (!$this->sale_reference) {
            $this->sale_reference = 'SALE' . str_pad(
                (Sale::max('id') ?? 0) + 1, 
                6, 
                '0', 
                STR_PAD_LEFT
            );
        }
    }

    public function calculateNetAmount(): void
    {
        $this->net_sale_amount = $this->sale_amount - $this->processing_fee;
    }

    public function calculateCommission(float $rate = null): void
    {
        $rate = $rate ?? $this->commission_rate;
        $this->commission_rate = $rate;
        $this->commission_amount = ($this->sale_amount * $rate) / 100;
    }

    public function confirm(): bool
    {
        return $this->update([
            'status' => 'confirmed',
            'confirmed_at' => now()
        ]);
    }

    public function markAsPaid(): bool
    {
        return $this->update([
            'payment_status' => 'paid'
        ]);
    }

    public function refund(string $reason = null): bool
    {
        return $this->update([
            'status' => 'refunded',
            'payment_status' => 'refunded'
        ]);
    }

    // Accessors
    public function getCommissionPercentageAttribute(): string
    {
        return $this->commission_rate . '%';
    }

    public function getFormattedSaleAmountAttribute(): string
    {
        return $this->currency . ' ' . number_format($this->sale_amount, 2);
    }

    public function getFormattedCommissionAmountAttribute(): string
    {
        return $this->currency . ' ' . number_format($this->commission_amount, 2);
    }

    public function getIsConfirmedAttribute(): bool
    {
        return $this->status === 'confirmed';
    }

    public function getIsPaidAttribute(): bool
    {
        return $this->payment_status === 'paid';
    }

    // Static Methods
    public static function createSale(array $data): self
    {
        // Calculate commission if not provided
        if (!isset($data['commission_amount']) && isset($data['commission_rate'])) {
            $data['commission_amount'] = ($data['sale_amount'] * $data['commission_rate']) / 100;
        }

        // Set sale date if not provided
        if (!isset($data['sale_date'])) {
            $data['sale_date'] = now();
        }

        // Calculate net amount
        $data['net_sale_amount'] = $data['sale_amount'] - ($data['processing_fee'] ?? 0);

        return static::create($data);
    }

    public static function getTotalSalesByAffiliate($affiliateId, $status = null): float
    {
        $query = static::where('affiliate_id', $affiliateId);
        
        if ($status) {
            $query->where('status', $status);
        }
        
        return $query->sum('sale_amount');
    }

    public static function getTotalCommissionByAffiliate($affiliateId, $status = 'confirmed'): float
    {
        return static::where('affiliate_id', $affiliateId)
                    ->where('status', $status)
                    ->sum('commission_amount');
    }

    public static function getMonthlySalesReport($month = null, $year = null): array
    {
        $month = $month ?? now()->month;
        $year = $year ?? now()->year;

        return static::whereMonth('sale_date', $month)
                    ->whereYear('sale_date', $year)
                    ->selectRaw('
                        COUNT(*) as total_sales,
                        SUM(sale_amount) as total_amount,
                        SUM(commission_amount) as total_commission,
                        AVG(sale_amount) as average_sale,
                        status
                    ')
                    ->groupBy('status')
                    ->get()
                    ->toArray();
    }
}

// Factory: SaleFactory.php