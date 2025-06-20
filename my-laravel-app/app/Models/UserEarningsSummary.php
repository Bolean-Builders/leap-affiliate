<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEarningsSummary extends Model
{
    use HasFactory;

    protected $table = 'user_earnings_summary';

    protected $fillable = [
        'user_id', 'user_type',
        'total_lifetime_earnings', 'available_balance', 'pending_balance',
        'this_month_earnings', 'last_month_earnings', 'year_to_date_earnings',
        'all_time_payout_total', 'total_payouts_count', 'largest_single_payout',
        'last_payout_date', 'current_earning_streak', 'best_earning_streak',
        'last_earning_date', 'highest_daily_earning', 'average_monthly_earning',
        'current_month', 'current_year', 'total_transactions', 'conversion_rate',
        'average_order_value', 'preferred_currency', 'minimum_payout_threshold',
        'is_payout_eligible', 'auto_payout_enabled', 'earning_status',
        'last_calculated_at'
    ];

    protected $casts = [
        'total_lifetime_earnings' => 'decimal:2',
        'available_balance' => 'decimal:2',
        'pending_balance' => 'decimal:2',
        'this_month_earnings' => 'decimal:2',
        'last_month_earnings' => 'decimal:2',
        'year_to_date_earnings' => 'decimal:2',
        'all_time_payout_total' => 'decimal:2',
        'largest_single_payout' => 'decimal:2',
        'last_payout_date' => 'datetime',
        'last_earning_date' => 'datetime',
        'highest_daily_earning' => 'decimal:2',
        'average_monthly_earning' => 'decimal:2',
        'conversion_rate' => 'decimal:2',
        'average_order_value' => 'decimal:2',
        'minimum_payout_threshold' => 'decimal:2',
        'is_payout_eligible' => 'boolean',
        'auto_payout_enabled' => 'boolean',
        'last_calculated_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
