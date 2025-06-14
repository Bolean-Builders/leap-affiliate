<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEarningsSummary extends Model
{
    use HasFactory;

    protected $table = 'user_earnings_summary';

    protected $fillable = [
        'user_id', 'user_type', 'total_lifetime_earnings', 
        'available_balance', 'pending_balance', 'this_month_earnings',
        'last_month_earnings', 'year_to_date_earnings'
    ];

    protected $casts = [
        'total_lifetime_earnings' => 'decimal:2',
        'available_balance' => 'decimal:2',
        'pending_balance' => 'decimal:2',
        'this_month_earnings' => 'decimal:2',
        'last_payout_date' => 'datetime',
        'last_earning_date' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}