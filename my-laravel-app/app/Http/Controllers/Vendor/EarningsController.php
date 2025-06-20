<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\UserEarningsSummary;

class EarningsController extends Controller
{
  public function index()
{
    $user = Auth::user();

    // Try to find earnings summary
    $earnings = UserEarningsSummary::where([
        'user_id' => $user->id,
        'user_type' => 'vendor',
    ])->first();

    if (!$earnings) {
        // Optional: flash message or create dummy summary
        session()->flash('warning', 'No earnings data found for this vendor.');
        // or: create a fallback summary object
        $earnings = new UserEarningsSummary([
            'user_id' => $user->id,
            'user_type' => 'vendor',
            'total_lifetime_earnings' => 0,
            'available_balance' => 0,
            'pending_balance' => 0,
        ]);
    }

      // Flash success message
        session()->flash('success', 'Earnings loaded successfully!');

    return view('vendor.earnings', compact('earnings'));
}
}
