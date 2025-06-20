@extends('layouts.app')

@section('title', 'My Earnings Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 font-inter">
    <div class="container-fluid py-8 px-4 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8" data-aos="fade-down">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-4xl font-bold text-white mb-2">Earnings Dashboard</h1>
                    <p class="text-purple-200/80 text-lg">{{ ucfirst($earnings->user_type) }} Account</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <span class="px-4 py-2 rounded-full text-sm font-semibold backdrop-blur-sm border border-white/20 
                        @if($earnings->earning_status === 'active') 
                            bg-emerald-500/20 text-emerald-300 border-emerald-400/30
                        @elseif($earnings->earning_status === 'suspended') 
                            bg-red-500/20 text-red-300 border-red-400/30
                        @else 
                            bg-yellow-500/20 text-yellow-300 border-yellow-400/30
                        @endif">
                        {{ ucfirst($earnings->earning_status) }}
                    </span>
                    @if($earnings->is_payout_eligible)
                        <span class="px-4 py-2 rounded-full text-sm font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 backdrop-blur-sm">
                            Payout Eligible
                        </span>
                    @else
                        <span class="px-4 py-2 rounded-full text-sm font-semibold bg-slate-500/20 text-slate-300 border border-slate-400/30 backdrop-blur-sm">
                            Payout Pending
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Main Balance Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="group" data-aos="fade-up" data-aos-delay="100">
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-500 via-purple-600 to-indigo-700 p-6 h-full backdrop-blur-xl border border-white/10 hover:border-white/20 transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                    <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent"></div>
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h6 class="text-indigo-200/70 text-sm font-medium mb-2">Available Balance</h6>
                                <h2 class="text-3xl font-bold text-white">{{ $earnings->preferred_currency }} {{ number_format($earnings->available_balance, 2) }}</h2>
                            </div>
                            <div class="p-3 rounded-xl bg-white/10 backdrop-blur-sm">
                                <i class="fas fa-wallet text-2xl text-white/70"></i>
                            </div>
                        </div>
                        <p class="text-indigo-200/60 text-sm">Ready for withdrawal</p>
                    </div>
                    <div class="absolute -bottom-2 -right-2 w-20 h-20 bg-white/5 rounded-full blur-xl"></div>
                </div>
            </div>

            <div class="group" data-aos="fade-up" data-aos-delay="200">
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-amber-400 via-yellow-500 to-orange-500 p-6 h-full backdrop-blur-xl border border-white/10 hover:border-white/20 transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                    <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent"></div>
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h6 class="text-amber-100/70 text-sm font-medium mb-2">Pending Balance</h6>
                                <h2 class="text-3xl font-bold text-white">{{ $earnings->preferred_currency }} {{ number_format($earnings->pending_balance, 2) }}</h2>
                            </div>
                            <div class="p-3 rounded-xl bg-white/10 backdrop-blur-sm">
                                <i class="fas fa-clock text-2xl text-white/70"></i>
                            </div>
                        </div>
                        <p class="text-amber-100/60 text-sm">Processing earnings</p>
                    </div>
                    <div class="absolute -bottom-2 -right-2 w-20 h-20 bg-white/5 rounded-full blur-xl"></div>
                </div>
            </div>

            <div class="group" data-aos="fade-up" data-aos-delay="300">
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-500 via-teal-600 to-cyan-600 p-6 h-full backdrop-blur-xl border border-white/10 hover:border-white/20 transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                    <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent"></div>
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h6 class="text-emerald-100/70 text-sm font-medium mb-2">Total Lifetime Earnings</h6>
                                <h2 class="text-3xl font-bold text-white">{{ $earnings->preferred_currency }} {{ number_format($earnings->total_lifetime_earnings, 2) }}</h2>
                            </div>
                            <div class="p-3 rounded-xl bg-white/10 backdrop-blur-sm">
                                <i class="fas fa-chart-line text-2xl text-white/70"></i>
                            </div>
                        </div>
                        <p class="text-emerald-100/60 text-sm">All-time total</p>
                    </div>
                    <div class="absolute -bottom-2 -right-2 w-20 h-20 bg-white/5 rounded-full blur-xl"></div>
                </div>
            </div>
        </div>

        <!-- Time-based Earnings -->
        <div class="mb-8" data-aos="fade-up" data-aos-delay="400">
            <div class="relative overflow-hidden rounded-2xl bg-white/5 backdrop-blur-xl border border-white/10 hover:border-white/20 transition-all duration-300">
                <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent"></div>
                <div class="relative z-10">
                    <div class="px-6 py-4 border-b border-white/10">
                        <h5 class="text-xl font-semibold text-white">Earnings Overview</h5>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            <div class="text-center p-4 rounded-xl bg-indigo-500/10 border border-indigo-400/20 hover:bg-indigo-500/20 transition-colors">
                                <h4 class="text-2xl font-bold text-indigo-300 mb-2">{{ $earnings->preferred_currency }} {{ number_format($earnings->this_month_earnings, 2) }}</h4>
                                <p class="text-slate-300 text-sm">This Month</p>
                            </div>
                            <div class="text-center p-4 rounded-xl bg-cyan-500/10 border border-cyan-400/20 hover:bg-cyan-500/20 transition-colors">
                                <h4 class="text-2xl font-bold text-cyan-300 mb-2">{{ $earnings->preferred_currency }} {{ number_format($earnings->last_month_earnings, 2) }}</h4>
                                <p class="text-slate-300 text-sm">Last Month</p>
                            </div>
                            <div class="text-center p-4 rounded-xl bg-emerald-500/10 border border-emerald-400/20 hover:bg-emerald-500/20 transition-colors">
                                <h4 class="text-2xl font-bold text-emerald-300 mb-2">{{ $earnings->preferred_currency }} {{ number_format($earnings->year_to_date_earnings, 2) }}</h4>
                                <p class="text-slate-300 text-sm">Year to Date</p>
                            </div>
                            <div class="text-center p-4 rounded-xl bg-amber-500/10 border border-amber-400/20 hover:bg-amber-500/20 transition-colors">
                                <h4 class="text-2xl font-bold text-amber-300 mb-2">{{ $earnings->preferred_currency }} {{ number_format($earnings->average_monthly_earning, 2) }}</h4>
                                <p class="text-slate-300 text-sm">Monthly Average</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Payout Information -->
            <div data-aos="fade-right" data-aos-delay="500">
                <div class="relative overflow-hidden rounded-2xl bg-white/5 backdrop-blur-xl border border-white/10 hover:border-white/20 transition-all duration-300 h-full">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-transparent"></div>
                    <div class="relative z-10">
                        <div class="px-6 py-4 border-b border-white/10">
                            <h5 class="text-xl font-semibold text-white flex items-center">
                                <i class="fas fa-money-bill-wave mr-3 text-purple-400"></i>
                                Payout Information
                            </h5>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex justify-between items-center p-3 rounded-lg bg-white/5 hover:bg-white/10 transition-colors">
                                    <span class="text-slate-300">Total Payouts:</span>
                                    <strong class="text-white text-lg">{{ $earnings->preferred_currency }} {{ number_format($earnings->all_time_payout_total, 2) }}</strong>
                                </div>
                                <div class="flex justify-between items-center p-3 rounded-lg bg-white/5 hover:bg-white/10 transition-colors">
                                    <span class="text-slate-300">Number of Payouts:</span>
                                    <strong class="text-white text-lg">{{ $earnings->total_payouts_count }}</strong>
                                </div>
                                <div class="flex justify-between items-center p-3 rounded-lg bg-white/5 hover:bg-white/10 transition-colors">
                                    <span class="text-slate-300">Largest Payout:</span>
                                    <strong class="text-white text-lg">{{ $earnings->preferred_currency }} {{ number_format($earnings->largest_single_payout, 2) }}</strong>
                                </div>
                                <div class="flex justify-between items-center p-3 rounded-lg bg-white/5 hover:bg-white/10 transition-colors">
                                    <span class="text-slate-300">Last Payout:</span>
                                    <strong class="text-white text-lg">
                                        @if($earnings->last_payout_date)
                                            {{ \Carbon\Carbon::parse($earnings->last_payout_date)->format('M j, Y') }}
                                        @else
                                            <span class="text-slate-400">No payouts yet</span>
                                        @endif
                                    </strong>
                                </div>
                                <div class="flex justify-between items-center p-3 rounded-lg bg-white/5 hover:bg-white/10 transition-colors">
                                    <span class="text-slate-300">Minimum Threshold:</span>
                                    <strong class="text-white text-lg">{{ $earnings->preferred_currency }} {{ number_format($earnings->minimum_payout_threshold, 2) }}</strong>
                                </div>
                                <div class="flex justify-between items-center p-3 rounded-lg bg-white/5 hover:bg-white/10 transition-colors">
                                    <span class="text-slate-300">Auto Payout:</span>
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold backdrop-blur-sm border 
                                        @if($earnings->auto_payout_enabled)
                                            bg-emerald-500/20 text-emerald-300 border-emerald-400/30
                                        @else
                                            bg-slate-500/20 text-slate-300 border-slate-400/30
                                        @endif">
                                        {{ $earnings->auto_payout_enabled ? 'Enabled' : 'Disabled' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Metrics -->
            <div data-aos="fade-left" data-aos-delay="600">
                <div class="relative overflow-hidden rounded-2xl bg-white/5 backdrop-blur-xl border border-white/10 hover:border-white/20 transition-all duration-300 h-full">
                    <div class="absolute inset-0 bg-gradient-to-br from-teal-500/5 to-transparent"></div>
                    <div class="relative z-10">
                        <div class="px-6 py-4 border-b border-white/10">
                            <h5 class="text-xl font-semibold text-white flex items-center">
                                <i class="fas fa-chart-bar mr-3 text-teal-400"></i>
                                Performance Metrics
                            </h5>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex justify-between items-center p-3 rounded-lg bg-white/5 hover:bg-white/10 transition-colors">
                                    <span class="text-slate-300">Current Streak:</span>
                                    <strong class="text-white text-lg">{{ $earnings->current_earning_streak }} days</strong>
                                </div>
                                <div class="flex justify-between items-center p-3 rounded-lg bg-white/5 hover:bg-white/10 transition-colors">
                                    <span class="text-slate-300">Best Streak:</span>
                                    <strong class="text-white text-lg">{{ $earnings->best_earning_streak }} days</strong>
                                </div>
                                <div class="flex justify-between items-center p-3 rounded-lg bg-white/5 hover:bg-white/10 transition-colors">
                                    <span class="text-slate-300">Highest Daily Earning:</span>
                                    <strong class="text-white text-lg">{{ $earnings->preferred_currency }} {{ number_format($earnings->highest_daily_earning, 2) }}</strong>
                                </div>
                                <div class="flex justify-between items-center p-3 rounded-lg bg-white/5 hover:bg-white/10 transition-colors">
                                    <span class="text-slate-300">Total Transactions:</span>
                                    <strong class="text-white text-lg">{{ number_format($earnings->total_transactions) }}</strong>
                                </div>
                                <div class="flex justify-between items-center p-3 rounded-lg bg-white/5 hover:bg-white/10 transition-colors">
                                    <span class="text-slate-300">Conversion Rate:</span>
                                    <strong class="text-white text-lg">{{ $earnings->conversion_rate }}%</strong>
                                </div>
                                <div class="flex justify-between items-center p-3 rounded-lg bg-white/5 hover:bg-white/10 transition-colors">
                                    <span class="text-slate-300">Average Order Value:</span>
                                    <strong class="text-white text-lg">{{ $earnings->preferred_currency }} {{ number_format($earnings->average_order_value, 2) }}</strong>
                                </div>
                                <div class="flex justify-between items-center p-3 rounded-lg bg-white/5 hover:bg-white/10 transition-colors">
                                    <span class="text-slate-300">Last Earning:</span>
                                    <strong class="text-white text-lg">
                                        @if($earnings->last_earning_date)
                                            {{ \Carbon\Carbon::parse($earnings->last_earning_date)->diffForHumans() }}
                                        @else
                                            <span class="text-slate-400">No earnings yet</span>
                                        @endif
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="group" data-aos="fade-up" data-aos-delay="700">
                <div class="relative overflow-hidden rounded-2xl bg-white/5 backdrop-blur-xl border border-white/10 hover:border-white/20 transition-all duration-300 p-6 text-center h-full group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-transparent"></div>
                    <div class="relative z-10">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-2xl text-white"></i>
                        </div>
                        <h5 class="text-xl font-semibold text-white mb-3">Active Period</h5>
                        <p class="text-slate-300">
                            <strong class="text-2xl block mb-1">{{ $earnings->current_month }}/{{ $earnings->current_year }}</strong>
                            <small class="text-slate-400">Current tracking period</small>
                        </p>
                    </div>
                </div>
            </div>

            <div class="group" data-aos="fade-up" data-aos-delay="800">
                <div class="relative overflow-hidden rounded-2xl bg-white/5 backdrop-blur-xl border border-white/10 hover:border-white/20 transition-all duration-300 p-6 text-center h-full group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-transparent"></div>
                    <div class="relative z-10">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center">
                            <i class="fas fa-coins text-2xl text-white"></i>
                        </div>
                        <h5 class="text-xl font-semibold text-white mb-3">Currency</h5>
                        <p class="text-slate-300">
                            <strong class="text-2xl block mb-1">{{ $earnings->preferred_currency }}</strong>
                            <small class="text-slate-400">Preferred currency</small>
                        </p>
                    </div>
                </div>
            </div>

            <div class="group" data-aos="fade-up" data-aos-delay="900">
                <div class="relative overflow-hidden rounded-2xl bg-white/5 backdrop-blur-xl border border-white/10 hover:border-white/20 transition-all duration-300 p-6 text-center h-full group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/5 to-transparent"></div>
                    <div class="relative z-10">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-cyan-500 to-teal-600 flex items-center justify-center">
                            <i class="fas fa-sync-alt text-2xl text-white"></i>
                        </div>
                        <h5 class="text-xl font-semibold text-white mb-3">Last Updated</h5>
                        <p class="text-slate-300">
                            <strong class="text-lg block mb-1">
                                @if($earnings->last_calculated_at)
                                    {{ \Carbon\Carbon::parse($earnings->last_calculated_at)->format('M j, Y') }}
                                @else
                                    Never
                                @endif
                            </strong>
                            <small class="text-slate-400">
                                @if($earnings->last_calculated_at)
                                    {{ \Carbon\Carbon::parse($earnings->last_calculated_at)->diffForHumans() }}
                                @else
                                    Awaiting calculation
                                @endif
                            </small>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Stats Row -->
        <div data-aos="fade-up" data-aos-delay="1000">
            <div class="relative overflow-hidden rounded-2xl bg-white/5 backdrop-blur-xl border border-white/10 hover:border-white/20 transition-all duration-300">
                <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent"></div>
                <div class="relative z-10">
                    <div class="px-6 py-4 border-b border-white/10">
                        <h5 class="text-xl font-semibold text-white flex items-center">
                            <i class="fas fa-chart-pie mr-3 text-rose-400"></i>
                            Account Summary
                        </h5>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 md:grid-cols-6 gap-6 text-center">
                            <div class="p-4 rounded-xl bg-white/5 hover:bg-white/10 transition-colors">
                                <div class="text-2xl font-bold text-white mb-1">{{ $earnings->user_type }}</div>
                                <div class="text-slate-400 text-sm">Account Type</div>
                            </div>
                            <div class="p-4 rounded-xl bg-white/5 hover:bg-white/10 transition-colors">
                                <div class="text-2xl font-bold text-white mb-1">{{ ucfirst($earnings->earning_status) }}</div>
                                <div class="text-slate-400 text-sm">Status</div>
                            </div>
                            <div class="p-4 rounded-xl bg-white/5 hover:bg-white/10 transition-colors">
                                <div class="text-2xl font-bold mb-1">
                                    @if($earnings->is_payout_eligible)
                                        <span class="text-emerald-400">Yes</span>
                                    @else
                                        <span class="text-red-400">No</span>
                                    @endif
                                </div>
                                <div class="text-slate-400 text-sm">Payout Eligible</div>
                            </div>
                            <div class="p-4 rounded-xl bg-white/5 hover:bg-white/10 transition-colors">
                                <div class="text-2xl font-bold mb-1">
                                    @if($earnings->auto_payout_enabled)
                                        <span class="text-indigo-400">Auto</span>
                                    @else
                                        <span class="text-slate-400">Manual</span>
                                    @endif
                                </div>
                                <div class="text-slate-400 text-sm">Payout Mode</div>
                            </div>
                            <div class="p-4 rounded-xl bg-white/5 hover:bg-white/10 transition-colors">
                                <div class="text-2xl font-bold text-white mb-1">{{ number_format($earnings->total_transactions) }}</div>
                                <div class="text-slate-400 text-sm">Total Sales</div>
                            </div>
                            <div class="p-4 rounded-xl bg-white/5 hover:bg-white/10 transition-colors">
                                <div class="text-2xl font-bold text-white mb-1">{{ $earnings->conversion_rate }}%</div>
                                <div class="text-slate-400 text-sm">Conversion</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Initialize AOS (Animate On Scroll)
    AOS.init({
        duration: 800,
        once: true,
        offset: 100
    });
</script>
@endsection

@push('styles')
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js" defer></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    :root {
        /* Gradient Colors - Matching Welcome Page */
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --indigo-gradient: linear-gradient(90deg, #6366f1 0%, #8b5cf6 100%);
        --success-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
        --warning-gradient: linear-gradient(135deg, #facc15 0%, #eab308 100%);
        --danger-gradient: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        --purple-gradient: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #a855f7 100%);
        --teal-gradient: linear-gradient(135deg, #0d9488 0%, #14b8a6 50%, #2dd4bf 100%);
        --rose-gradient: linear-gradient(135deg, #e11d48 0%, #f43f5e 50%, #fb7185 100%);
        
        /* Glassmorphism Effects */
        --glass-bg: rgba(0, 0, 0, 0.4);
        --glass-bg-hover: rgba(0, 0, 0, 0.5);
        --glass-border: rgba(255, 255, 255, 0.15);
        --glass-blur: blur(20px);
        
        /* Card Backgrounds */
        --card-bg-primary: rgba(99, 102, 241, 0.1);
        --card-bg-success: rgba(16, 185, 129, 0.1);
        --card-bg-warning: rgba(245, 158, 11, 0.1);
        --card-bg-danger: rgba(239, 68, 68, 0.1);
    }

    .font-inter {
        font-family: 'Inter', sans-serif;
    }

    /* Custom scrollbar for webkit browsers */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.1);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    /* Smooth transitions for all elements */
    * {
        transition: all 0.3s ease;
    }
</style>
@endpush