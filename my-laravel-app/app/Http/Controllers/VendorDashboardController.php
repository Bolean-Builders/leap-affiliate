<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\UserEarningsSummary;
use Illuminate\Support\Facades\Auth;

class VendorDashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        
        // Check if user has vendor role
        $this->middleware(function ($request, $next) {
            if (auth()->check() && auth()->user()->role !== 'vendor') {
                abort(403, 'Access denied. Vendor access required.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $earnings = $this->getEarningsData();
        $username = Auth::user()->username;
        $role = Auth::user()->role;

          session()->flash('success', 'vendor dasboard loaded successfully!');
        
        // Pass all variables to the view - corrected to use 'vendors' (plural)
        return view('vendor.vendash', compact('earnings', 'username', 'role'));
    }
    
    public function getEarningsData()
    {
        return UserEarningsSummary::where('user_id', Auth::id())
            ->where('user_type', 'vendor')
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

    public function products()
{
    return view('vendor.products');
}



}