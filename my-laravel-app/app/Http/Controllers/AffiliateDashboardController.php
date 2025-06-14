<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\UserEarningsSummary;
use Illuminate\Support\Facades\Auth;

class AffiliateDashboardController extends Controller
{
    public function index()
    {
        $earnings = $this->getEarningsData();
        $username = Auth::user()->username;
        $role = Auth::user()->role;
        
        // Pass all variables to the view
        return view('affiliate.affdash', compact('earnings', 'username', 'role'));
    }
    
    public function getEarningsData()
    {
        return UserEarningsSummary::where('user_id', Auth::id())
            ->where('user_type', 'affiliate')
            ->first() ?? $this->createDefaultEarnings();
    }
    
    private function createDefaultEarnings()
    {
        // Return a UserEarningsSummary-like object with default values
        return (object) [
            'total_lifetime_earnings' => '0.00',
            'available_balance' => '0.00',
            'pending_balance' => '0.00',
            'this_month_earnings' => '0.00',
            'last_month_earnings' => '0.00',
            'year_to_date_earnings' => '0.00'
        ];
    }
}