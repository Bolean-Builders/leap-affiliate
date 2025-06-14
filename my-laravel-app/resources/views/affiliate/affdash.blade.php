<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Laravel App</title>
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

        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: var(--primary-gradient);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background Shapes - Matching Welcome Page */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(99, 102, 241, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(236, 72, 153, 0.12) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(14, 165, 233, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 90% 90%, rgba(168, 85, 247, 0.08) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }

        .glass-card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .gradient-text {
            background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 50%, #f472b6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .btn-primary {
            background: var(--indigo-gradient);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(99, 102, 241, 0.4);
        }

        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .floating-animation:nth-child(2) {
            animation-delay: -2s;
        }

        .floating-animation:nth-child(3) {
            animation-delay: -4s;
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.35);
            background: var(--glass-bg-hover);
        }

        .table-glass {
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .navbar-glass {
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(25px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        }

        /* Status badges */
        .status-pending {
            background: var(--warning-gradient);
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }

        .status-completed {
            background: var(--success-gradient);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .status-rejected {
            background: var(--danger-gradient);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        .pulse-glow {
            animation: pulse-glow 3s infinite;
        }

        @keyframes pulse-glow {
            0% { box-shadow: 0 0 20px rgba(99, 102, 241, 0.4), 0 0 40px rgba(168, 85, 247, 0.2); }
            50% { box-shadow: 0 0 30px rgba(99, 102, 241, 0.6), 0 0 60px rgba(168, 85, 247, 0.4); }
            100% { box-shadow: 0 0 20px rgba(99, 102, 241, 0.4), 0 0 40px rgba(168, 85, 247, 0.2); }
        }

        /* Animated background shapes */
        .floating-shape {
            animation: float 6s ease-in-out infinite;
        }

        .floating-shape:nth-child(2) {
            animation-delay: -2s;
        }

        .floating-shape:nth-child(3) {
            animation-delay: -4s;
        }

        .floating-shape:nth-child(4) {
            animation-delay: -1s;
        }

        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(99, 102, 241, 0.5);
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(99, 102, 241, 0.7);
        }
    </style>
</head>
  @include('partials.affiliate.navbar')
<body x-data="dashboardData()">
    <!-- Animated Background Shapes -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="floating-shape absolute top-20 left-10 w-32 h-32 bg-white/10 rounded-full blur-xl"></div>
        <div class="floating-shape absolute top-40 right-20 w-24 h-24 bg-purple-300/20 rounded-full blur-lg"></div>
        <div class="floating-shape absolute bottom-20 left-20 w-40 h-40 bg-indigo-300/10 rounded-full blur-2xl"></div>
        <div class="floating-shape absolute bottom-40 right-10 w-28 h-28 bg-pink-300/15 rounded-full blur-xl"></div>
    </div>

    <!-- Navigation -->
    <!-- <nav class="navbar-glass sticky top-0 z-50 px-6 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="text-2xl font-bold text-white">
                    <i class="fas fa-tachometer-alt mr-2 gradient-text"></i>
                    Dashboard
                </div>
            </div>
            
            <div class="flex items-center space-x-6">
                <div class="hidden md:flex items-center space-x-6 text-white/80">
                    <a href="#" class="hover:text-white transition-colors flex items-center">
                        <i class="fas fa-home mr-2"></i>Home
                    </a>
                    <a href="#" class="hover:text-white transition-colors flex items-center">
                        <i class="fas fa-chart-bar mr-2"></i>Analytics
                    </a>
                    <a href="#" class="hover:text-white transition-colors flex items-center">
                        <i class="fas fa-cog mr-2"></i>Settings
                    </a>
                </div>
                
                <div class="flex items-center space-x-3 text-white">
                    <div class="text-right hidden sm:block">
                        <div class="font-medium"></div>
                        <div class="text-sm text-white/60">{{ Auth::user()->role }}</div>
                    </div>
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500/30 to-purple-500/30 rounded-full flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-user text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </nav> -->

    <!-- Main Dashboard -->
    <main class="max-w-7xl mx-auto px-6 py-8 relative z-10">
        <!-- Header -->
        <div class="mb-8" data-aos="fade-down">
            <h1 class="text-4xl font-bold text-white mb-2">
                Welcome back, <span class="gradient-text">{{ Auth::user()->username }} 😂 </span>
            </h1>
            <p class="text-white/70 text-lg">Here's what's happening in your dashboard today</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Lifetime Earnings -->
            <div class="glass-card rounded-2xl p-6 card-hover floating-animation" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-gradient-to-br from-emerald-500/20 to-teal-500/20 rounded-xl backdrop-blur-sm border border-emerald-500/30">
                        <i class="fas fa-chart-line text-emerald-300 text-xl"></i>
                    </div>
                </div>
                <h3 class="text-white/90 text-sm font-medium mb-1">Total Lifetime Earnings</h3>
                <p class="text-white text-3xl font-bold mb-2 gradient-text">${{ number_format($earnings->total_lifetime_earnings, 2) }}</p>
                <small class="text-white/60">All time earnings</small>
            </div>

            <!-- This Month Earnings -->
            <div class="glass-card rounded-2xl p-6 card-hover floating-animation" data-aos="fade-up" data-aos-delay="200">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-xl backdrop-blur-sm border border-blue-500/30">
                        <i class="fas fa-calendar-month text-blue-300 text-xl"></i>
                    </div>
                    @php
                        $monthlyGrowth = 0;
                        if ($earnings->last_month_earnings > 0) {
                            $monthlyGrowth = (($earnings->this_month_earnings - $earnings->last_month_earnings) / $earnings->last_month_earnings) * 100;
                        } elseif ($earnings->this_month_earnings > 0) {
                            $monthlyGrowth = 100; // New earnings this month
                        }
                    @endphp
                    @if($monthlyGrowth != 0)
                        <div class="px-2 py-1 bg-{{ $monthlyGrowth > 0 ? 'blue' : 'red' }}-500/20 rounded-full border border-{{ $monthlyGrowth > 0 ? 'blue' : 'red' }}-500/30">
                            <span class="text-{{ $monthlyGrowth > 0 ? 'blue' : 'red' }}-300 text-xs font-medium">
                                {{ $monthlyGrowth > 0 ? '+' : '' }}{{ number_format($monthlyGrowth, 1) }}%
                            </span>
                        </div>
                    @endif
                </div>
                <h3 class="text-white/90 text-sm font-medium mb-1">This Month Earnings</h3>
                <p class="text-white text-3xl font-bold mb-2 gradient-text">${{ number_format($earnings->this_month_earnings, 2) }}</p>
                <small class="text-white/60">{{ date('F Y') }} earnings</small>
            </div>

            <!-- Available Balance (Payout Ready) -->
            <div class="glass-card rounded-2xl p-6 card-hover pulse-glow" data-aos="fade-up" data-aos-delay="300">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-gradient-to-br from-purple-500/20 to-violet-500/20 rounded-xl backdrop-blur-sm border border-purple-500/30">
                        <i class="fas fa-wallet text-purple-300 text-xl"></i>
                    </div>
                    <div class="px-2 py-1 bg-purple-500/20 rounded-full border border-purple-500/30">
                        <span class="text-purple-300 text-xs font-medium">Ready</span>
                    </div>
                </div>
                <h3 class="text-white/90 text-sm font-medium mb-1">Available Balance</h3>
                <p class="text-white text-2xl font-bold mb-3 gradient-text">${{ number_format($earnings->available_balance, 2) }}</p>
                <button class="btn-primary w-full py-2 px-4 rounded-xl text-white font-medium text-sm">
                    <i class="fas fa-download mr-2"></i>Request Payout
                </button>
            </div>

            <!-- Total Sales/Referrals -->
            <div class="glass-card rounded-2xl p-6 card-hover floating-animation" data-aos="fade-up" data-aos-delay="400">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-gradient-to-br from-pink-500/20 to-rose-500/20 rounded-xl backdrop-blur-sm border border-pink-500/30">
                        <i class="fas fa-handshake text-pink-300 text-xl"></i>
                    </div>
                    <div class="px-2 py-1 bg-pink-500/20 rounded-full border border-pink-500/30">
                        <span class="text-pink-300 text-xs font-medium">Active</span>
                    </div>
                </div>
                <h3 class="text-white/90 text-sm font-medium mb-1">Total Referrals</h3>
                <p class="text-white text-3xl font-bold mb-2 gradient-text">{{ $earnings->total_referrals ?? 0 }}</p>
                <small class="text-white/60">Successful referrals</small>
            </div>
        </div>

        <!-- Dashboard Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Earnings Summary Card -->
            <div class="glass-card rounded-2xl p-6" data-aos="fade-right">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-white text-xl font-bold">Earnings Summary</h3>
                    <i class="fas fa-chart-pie text-white/60"></i>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-3 bg-gradient-to-r from-emerald-500/10 to-teal-500/10 rounded-xl backdrop-blur-sm border border-emerald-500/20">
                        <span class="text-white/80">Available Balance</span>
                        <span class="text-emerald-300 font-bold">${{ number_format($earnings->available_balance, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gradient-to-r from-amber-500/10 to-orange-500/10 rounded-xl backdrop-blur-sm border border-amber-500/20">
                        <span class="text-white/80">Pending Balance</span>
                        <span class="text-amber-300 font-bold">${{ number_format($earnings->pending_balance, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gradient-to-r from-blue-500/10 to-cyan-500/10 rounded-xl backdrop-blur-sm border border-blue-500/20">
                        <span class="text-white/80">This Month</span>
                        <span class="text-blue-300 font-bold">${{ number_format($earnings->this_month_earnings, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gradient-to-r from-purple-500/10 to-violet-500/10 rounded-xl backdrop-blur-sm border border-purple-500/20">
                        <span class="text-white/80">Year to Date</span>
                        <span class="text-purple-300 font-bold">${{ number_format($earnings->year_to_date_earnings, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="lg:col-span-2">
                <div class="glass-card rounded-2xl p-6" data-aos="fade-left">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-white text-xl font-bold">Recent Activity</h3>
                        <button class="text-white/60 hover:text-white transition-colors">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                    </div>
                    <div class="space-y-4 max-h-80 overflow-y-auto custom-scrollbar">
                        <div class="flex items-center space-x-4 p-4 bg-gradient-to-r from-emerald-500/10 to-teal-500/10 rounded-xl backdrop-blur-sm border border-emerald-500/20">
                            <div class="w-10 h-10 bg-gradient-to-br from-emerald-500/30 to-teal-500/30 rounded-full flex items-center justify-center backdrop-blur-sm">
                                <i class="fas fa-dollar-sign text-emerald-300"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-white font-medium">Commission earned</p>
                                <p class="text-emerald-300 text-sm">New referral conversion</p>
                            </div>
                            <div class="text-white/60 text-sm">2m ago</div>
                        </div>
                        
                        <div class="flex items-center space-x-4 p-4 bg-gradient-to-r from-blue-500/10 to-cyan-500/10 rounded-xl backdrop-blur-sm border border-blue-500/20">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500/30 to-cyan-500/30 rounded-full flex items-center justify-center backdrop-blur-sm">
                                <i class="fas fa-user-plus text-blue-300"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-white font-medium">New referral</p>
                                <p class="text-blue-300 text-sm">User signed up via your link</p>
                            </div>
                            <div class="text-white/60 text-sm">15m ago</div>
                        </div>
                        
                        <div class="flex items-center space-x-4 p-4 bg-gradient-to-r from-purple-500/10 to-violet-500/10 rounded-xl backdrop-blur-sm border border-purple-500/20">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-500/30 to-violet-500/30 rounded-full flex items-center justify-center backdrop-blur-sm">
                                <i class="fas fa-bell text-purple-300"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-white font-medium">Payout processed</p>
                                <p class="text-purple-300 text-sm">$250.00 sent to your account</p>
                            </div>
                            <div class="text-white/60 text-sm">1h ago</div>
                        </div>

                        <div class="flex items-center space-x-4 p-4 bg-gradient-to-r from-amber-500/10 to-orange-500/10 rounded-xl backdrop-blur-sm border border-amber-500/20">
                            <div class="w-10 h-10 bg-gradient-to-br from-amber-500/30 to-orange-500/30 rounded-full flex items-center justify-center backdrop-blur-sm">
                                <i class="fas fa-clock text-amber-300"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-white font-medium">Commission pending</p>
                                <p class="text-amber-300 text-sm">Awaiting payment verification</p>
                            </div>
                            <div class="text-white/60 text-sm">2h ago</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="table-glass rounded-2xl overflow-hidden" data-aos="fade-up">
            <div class="p-6 border-b border-white/10">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-white text-xl font-bold">Recent Transactions</h3>
                        <p class="text-white/60 mt-1">Track all your recent activities and transactions</p>
                    </div>
                    <button class="btn-primary px-4 py-2 rounded-lg text-white font-medium text-sm">
                        <i class="fas fa-download mr-2"></i>Export
                    </button>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-white/5">
                        <tr>
                            <th class="px-6 py-4 text-left text-white/80 font-medium">ID</th>
                            <th class="px-6 py-4 text-left text-white/80 font-medium">Description</th>
                            <th class="px-6 py-4 text-left text-white/80 font-medium">Amount</th>
                            <th class="px-6 py-4 text-left text-white/80 font-medium">Date</th>
                            <th class="px-6 py-4 text-left text-white/80 font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4 text-white font-mono">#COM-001</td>
                            <td class="px-6 py-4 text-white font-medium">Referral Commission</td>
                            <td class="px-6 py-4 text-white font-bold">+$125.00</td>
                            <td class="px-6 py-4 text-white/80">June 10, 2025</td>
                            <td class="px-6 py-4">
                                <span class="status-completed px-3 py-1 rounded-full text-white text-sm font-medium">
                                    <i class="fas fa-check mr-1"></i>Completed
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4 text-white font-mono">#COM-002</td>
                            <td class="px-6 py-4 text-white font-medium">Signup Bonus</td>
                            <td class="px-6 py-4 text-white font-bold">+$25.00</td>
                            <td class="px-6 py-4 text-white/80">June 09, 2025</td>
                            <td class="px-6 py-4">
                                <span class="status-pending px-3 py-1 rounded-full text-white text-sm font-medium">
                                    <i class="fas fa-clock mr-1"></i>Pending
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4 text-white font-mono">#PAY-003</td>
                            <td class="px-6 py-4 text-white font-medium">Payout Request</td>
                            <td class="px-6 py-4 text-white font-bold">-$250.00</td>
                            <td class="px-6 py-4 text-white/80">June 08, 2025</td>
                            <td class="px-6 py-4">
                                <span class="status-completed px-3 py-1 rounded-full text-white text-sm font-medium">
                                    <i class="fas fa-check mr-1"></i>Completed
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4 text-white font-mono">#COM-004</td>
                            <td class="px-6 py-4 text-white font-medium">Monthly Bonus</td>
                            <td class="px-6 py-4 text-white font-bold">+$50.00</td>
                            <td class="px-6 py-4 text-white/80">June 07, 2025</td>
                            <td class="px-6 py-4">
                                <span class="status-completed px-3 py-1 rounded-full text-white text-sm font-medium">
                                    <i class="fas fa-check mr-1"></i>Completed
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="p-6 bg-white/5 flex items-center justify-between">
                <p class="text-white/60 text-sm">Showing 4 of 24 entries</p>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 bg-white/10 text-white rounded-lg hover:bg-white/20 transition-colors">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="px-3 py-1 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition-colors font-medium">1</button>
                    <button class="px-3 py-1 bg-white/10 text-white rounded-lg hover:bg-white/20 transition-colors">2</button>
                    <button class="px-3 py-1 bg-white/10 text-white rounded-lg hover:bg-white/20 transition-colors">3</button>
                    <button class="px-3 py-1 bg-white/10 text-white rounded-lg hover:bg-white/20 transition-colors">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </main>

    <!-- Alpine.js Dashboard Data -->
    <script>
        function dashboardData() {
            return {
                // Dashboard state data
                stats: {
                    revenue: 24567,
                    users: 2847,
                    tasks: 15,
                    growth: 23.4
                },
                
                activities: [
                    {
                        id: 1,
                        type: 'success',
                        icon: 'fas fa-check',
                        title: 'Task completed successfully',
                        description: 'Project Alpha milestone reached',
                        time: '2m ago',
                        gradient: 'from-emerald-500/10 to-teal-500/10'
                    },
                    {
                        id: 2,
                        type: 'info',
                        icon: 'fas fa-user-plus',
                        title: 'New user registered',
                        description: 'Welcome Sarah Johnson',
                        time: '15m ago',
                        gradient: 'from-blue-500/10 to-cyan-500/10'
                    },
                    {
                        id: 3,
                        type: 'notification',
                        icon: 'fas fa-bell',
                        title: 'System notification',
                        description: 'Backup completed successfully',
                        time: '1h ago',
                        gradient: 'from-purple-500/10 to-violet-500/10'
                    },
                    {
                        id: 4,
                        type: 'warning',
                        icon: 'fas fa-exclamation-triangle',
                        title: 'Warning alert',
                        description: 'Server load is high',
                        time: '2h ago',
                        gradient: 'from-amber-500/10 to-orange-500/10'
                    }
                ],
                
                transactions: [
                    {
                        id: 'TXN-001',
                        description: 'Product Purchase',
                        amount: '+$1,250.00',
                        date: 'June 10, 2025',
                        status: 'completed'
                    },
                    {
                        id: 'TXN-002',
                        description: 'Service Payment',
                        amount: '+$875.50',
                        date: 'June 09, 2025',
                        status: 'pending'
                    },
                    {
                        id: 'TXN-003',
                        description: 'Subscription Renewal',
                        amount: '+$299.00',
                        date: 'June 08, 2025',
                        status: 'completed'
                    },
                    {
                        id: 'TXN-004',
                        description: 'Refund Request',
                        amount: '-$150.00',
                        date: 'June 07, 2025',
                        status: 'rejected'
                    }
                ],
                
                // Methods
                formatCurrency(amount) {
                    return new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'USD'
                    }).format(amount);
                },
                
                getStatusClass(status) {
                    const classes = {
                        'completed': 'status-completed',
                        'pending': 'status-pending',
                        'rejected': 'status-rejected'
                    };
                    return classes[status] || 'status-pending';
                },
                
                getStatusIcon(status) {
                    const icons = {
                        'completed': 'fas fa-check',
                        'pending': 'fas fa-clock',
                        'rejected': 'fas fa-times'
                    };
                    return icons[status] || 'fas fa-clock';
                }
            }
        }

        // Initialize AOS (Animate On Scroll)
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true,
                offset: 100
            });
        });

        // Auto-refresh dashboard data every 30 seconds
        setInterval(() => {
            // In a real application, you would fetch new data from your API
            console.log('Refreshing dashboard data...');
        }, 30000);

        // Add smooth scrolling behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + K for search (if you add search functionality)
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                console.log('Search shortcut activated');
            }
            
            // Escape to close modals (if you add modal functionality)
            if (e.key === 'Escape') {
                console.log('Escape pressed');
            }
        });

        // Add responsive behavior for mobile navigation
        function toggleMobileNav() {
            const mobileNav = document.getElementById('mobile-nav');
            if (mobileNav) {
                mobileNav.classList.toggle('hidden');
            }
        }

        // Add notification system
        function showNotification(title, message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 glass-card rounded-lg p-4 max-w-sm transform transition-all duration-300 translate-x-full opacity-0`;
            
            const typeClasses = {
                'success': 'border-emerald-500/30 bg-emerald-500/10',
                'error': 'border-red-500/30 bg-red-500/10',
                'warning': 'border-amber-500/30 bg-amber-500/10',
                'info': 'border-blue-500/30 bg-blue-500/10'
            };
            
            notification.classList.add(typeClasses[type] || typeClasses.info);
            
            notification.innerHTML = `
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'} text-white"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-white font-medium text-sm">${title}</h4>
                        <p class="text-white/80 text-xs mt-1">${message}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-white/60 hover:text-white">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full', 'opacity-0');
            }, 100);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                notification.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => notification.remove(), 300);
            }, 5000);
        }

        // Example usage of notification system
        setTimeout(() => {
            showNotification('Welcome!', 'Dashboard loaded successfully', 'success');
        }, 1000);
    </script>

    <!-- Footer -->
    <footer class="mt-16 py-8 border-t border-white/10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="text-white/60 text-sm">
                    © 2025 Dashboard App. All rights reserved.
                </div>
                <div class="flex items-center space-x-6 mt-4 md:mt-0 text-white/60 text-sm">
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                    <a href="#" class="hover:text-white transition-colors">Support</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>