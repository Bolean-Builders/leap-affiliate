<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leap Affiliate Navbar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* Gradient Colors */
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --indigo-gradient: linear-gradient(90deg, #6366f1 0%, #8b5cf6 100%);
            
            /* Glassmorphism Effects */
            --glass-bg: rgba(0, 0, 0, 0.4);
            --glass-bg-hover: rgba(0, 0, 0, 0.5);
            --glass-border: rgba(255, 255, 255, 0.15);
            --glass-blur: blur(20px);
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

        /* Animated Background Shapes */
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

        .navbar-glass {
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(25px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        }

        .gradient-text {
            background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 50%, #f472b6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .dropdown {
            transform: translateY(-10px);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .dropdown.show {
            transform: translateY(0);
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        .dropdown-item {
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        .nav-item {
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-item:hover {
            color: #60a5fa;
        }

        .mobile-menu {
            transform: translateX(100%);
            transition: transform 0.3s ease;
        }

        .mobile-menu.open {
            transform: translateX(0);
        }

        .nav-icon {
            transition: all 0.3s ease;
        }

        .nav-item:hover .nav-icon {
            transform: scale(1.1);
            color: #60a5fa;
        }

        /* Profile dropdown glass effect */
        .profile-dropdown {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Notification badge */
        .notification-badge {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        /* Logo hover effect */
        .logo-hover {
            transition: all 0.3s ease;
        }

        .logo-hover:hover {
            transform: scale(1.05);
        }

        /* Mobile hamburger animation */
        .hamburger-line {
            transition: all 0.3s ease;
        }

        .hamburger.open .hamburger-line:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .hamburger.open .hamburger-line:nth-child(2) {
            opacity: 0;
        }

        .hamburger.open .hamburger-line:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -6px);
        }

        /* Prevent body scroll when mobile menu is open */
        body.mobile-menu-open {
            overflow: hidden;
            position: fixed;
            width: 100%;
        }

        /* Updated Mobile Menu Styles with New Colors */
        .mobile-menu-item {
            transition: all 0.3s ease;
            border-radius: 12px;
            margin-bottom: 4px;
            color: #e2e8f0; /* Light slate color */
        }

        .mobile-menu-item:hover {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(139, 92, 246, 0.15));
            transform: translateX(4px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
            color: #3b82f6; /* Blue color on hover */
        }

        .mobile-menu-item:active {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.25), rgba(139, 92, 246, 0.25));
            transform: translateX(2px) scale(0.98);
            color: #1d4ed8; /* Darker blue on active */
        }

        .mobile-dropdown-item {
            transition: all 0.25s ease;
            border-radius: 8px;
            margin-bottom: 2px;
            color: #cbd5e1; /* Lighter slate for dropdown items */
        }

        .mobile-dropdown-item:hover {
            background: rgba(34, 197, 94, 0.12);
            transform: translateX(2px);
            padding-left: 12px;
            color: #10b981; /* Emerald green on hover */
        }

        .mobile-user-info {
            background: rgba(99, 102, 241, 0.15);
            border: 1px solid rgba(99, 102, 241, 0.3);
            backdrop-filter: blur(10px);
        }

        .mobile-logout-btn {
            transition: all 0.3s ease;
            color: #f87171; /* Light red */
        }

        .mobile-logout-btn:hover {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            transform: translateX(2px);
            color: #ef4444; /* Brighter red on hover */
        }

        .mobile-menu-bg {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.95), rgba(30, 41, 59, 0.95));
            backdrop-filter: blur(20px);
            border-left: 1px solid rgba(59, 130, 246, 0.2);
        }

        /* Custom icon colors for mobile menu */
        .mobile-menu-item .mobile-icon-home { color: #3b82f6; } /* Blue */
        .mobile-menu-item .mobile-icon-products { color: #10b981; } /* Emerald */
        .mobile-menu-item .mobile-icon-analytics { color: #8b5cf6; } /* Purple */
        .mobile-menu-item .mobile-icon-profile { color: #f59e0b; } /* Amber */
        .mobile-menu-item .mobile-icon-help { color: #ef4444; } /* Red */
        .mobile-menu-item .mobile-icon-notifications { color: #ec4899; } /* Pink */
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar-glass sticky top-0 z-50 px-4 sm:px-6 py-4" x-data="navbarData()">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center space-x-4">
                <div class="text-xl sm:text-2xl font-bold text-white logo-hover cursor-pointer">
                    <i class="fas fa-rocket mr-2 gradient-text"></i>
                    <span class="gradient-text">Leap Affiliate</span>
                </div>
            </div>
            
            <!-- Desktop Navigation - Hidden on mobile/tablet -->
            <div class="hidden lg:flex items-center space-x-8">
                <!-- Home -->
                <div class="nav-item group">
                    <a href="#" class="flex items-center text-white/80 hover:text-white transition-colors">
                        <i class="fas fa-home nav-icon mr-2"></i>Home
                    </a>
                </div>

                <!-- Marketplace -->
                <div class="nav-item relative" @mouseenter="showDropdown('marketplace')" @mouseleave="hideDropdown('marketplace')">
                    <a href="#" class="flex items-center text-white/80 hover:text-white transition-colors">
                        <i class="fas fa-store nav-icon mr-2"></i>Marketplace
                        <i class="fas fa-chevron-down ml-1 text-xs transition-transform" :class="{'rotate-180': activeDropdown === 'marketplace'}"></i>
                    </a>
                    <div class="dropdown absolute top-full left-0 mt-2 w-64 profile-dropdown rounded-xl shadow-2xl py-2" 
                         :class="{'show': activeDropdown === 'marketplace'}">
                        <a href="#" class="dropdown-item flex items-center px-4 py-3 text-white/90 text-sm">
                            <i class="fas fa-shopping-cart mr-3 text-blue-400"></i>
                            <div>
                                <div class="font-medium">Browse Products</div>
                                <div class="text-white/60 text-xs">Discover amazing offers</div>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item flex items-center px-4 py-3 text-white/90 text-sm">
                            <i class="fas fa-tags mr-3 text-green-400"></i>
                            <div>
                                <div class="font-medium">Featured Deals</div>
                                <div class="text-white/60 text-xs">Hot deals & discounts</div>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item flex items-center px-4 py-3 text-white/90 text-sm">
                            <i class="fas fa-fire mr-3 text-red-400"></i>
                            <div>
                                <div class="font-medium">Trending Now</div>
                                <div class="text-white/60 text-xs">Popular products</div>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item flex items-center px-4 py-3 text-white/90 text-sm">
                            <i class="fas fa-star mr-3 text-yellow-400"></i>
                            <div>
                                <div class="font-medium">Top Rated</div>
                                <div class="text-white/60 text-xs">Best reviewed items</div>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- Analytics -->
                <div class="nav-item group">
                    <a href="#" class="flex items-center text-white/80 hover:text-white transition-colors">
                        <i class="fas fa-chart-bar nav-icon mr-2"></i>Analytics
                    </a>
                </div>

                <!-- Profile -->
                <div class="nav-item relative" @mouseenter="showDropdown('profile')" @mouseleave="hideDropdown('profile')">
                    <a href="#" class="flex items-center text-white/80 hover:text-white transition-colors">
                        <i class="fas fa-user nav-icon mr-2"></i>Profile
                        <i class="fas fa-chevron-down ml-1 text-xs transition-transform" :class="{'rotate-180': activeDropdown === 'profile'}"></i>
                    </a>
                    <div class="dropdown absolute top-full left-0 mt-2 w-64 profile-dropdown rounded-xl shadow-2xl py-2"
                         :class="{'show': activeDropdown === 'profile'}">
                        <a href="#" class="dropdown-item flex items-center px-4 py-3 text-white/90 text-sm">
                            <i class="fas fa-user-circle mr-3 text-blue-400"></i>
                            <div>
                                <div class="font-medium">My Profile</div>
                                <div class="text-white/60 text-xs">View & edit profile</div>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item flex items-center px-4 py-3 text-white/90 text-sm">
                            <i class="fas fa-wallet mr-3 text-green-400"></i>
                            <div>
                                <div class="font-medium">Earnings</div>
                                <div class="text-white/60 text-xs">Track your income</div>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item flex items-center px-4 py-3 text-white/90 text-sm">
                            <i class="fas fa-link mr-3 text-purple-400"></i>
                            <div>
                                <div class="font-medium">Affiliate Links</div>
                                <div class="text-white/60 text-xs">Manage your links</div>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item flex items-center px-4 py-3 text-white/90 text-sm">
                            <i class="fas fa-cog mr-3 text-gray-400"></i>
                            <div>
                                <div class="font-medium">Settings</div>
                                <div class="text-white/60 text-xs">Account preferences</div>
                            </div>
                        </a>
                        <div class="border-t border-white/10 my-2"></div>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item flex items-center px-4 py-3 text-red-400 text-sm">
                            <i class="fas fa-sign-out-alt mr-3"></i>
                            <div class="font-medium">Sign Out</div>
                        </a>

                        <!-- Hidden logout form -->
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>

                <!-- Help Center -->
                <div class="nav-item relative" @mouseenter="showDropdown('help')" @mouseleave="hideDropdown('help')">
                    <a href="#" class="flex items-center text-white/80 hover:text-white transition-colors">
                        <i class="fas fa-question-circle nav-icon mr-2"></i>Help Center
                        <i class="fas fa-chevron-down ml-1 text-xs transition-transform" :class="{'rotate-180': activeDropdown === 'help'}"></i>
                    </a>
                    <div class="dropdown absolute top-full right-0 mt-2 w-64 profile-dropdown rounded-xl shadow-2xl py-2"
                         :class="{'show': activeDropdown === 'help'}">
                        <a href="#" class="dropdown-item flex items-center px-4 py-3 text-white/90 text-sm">
                            <i class="fas fa-book mr-3 text-blue-400"></i>
                            <div>
                                <div class="font-medium">Documentation</div>
                                <div class="text-white/60 text-xs">Complete guide</div>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item flex items-center px-4 py-3 text-white/90 text-sm">
                            <i class="fas fa-video mr-3 text-red-400"></i>
                            <div>
                                <div class="font-medium">Video Tutorials</div>
                                <div class="text-white/60 text-xs">Step-by-step videos</div>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item flex items-center px-4 py-3 text-white/90 text-sm">
                            <i class="fas fa-comments mr-3 text-green-400"></i>
                            <div>
                                <div class="font-medium">Live Chat</div>
                                <div class="text-white/60 text-xs">Get instant help</div>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item flex items-center px-4 py-3 text-white/90 text-sm">
                            <i class="fas fa-ticket-alt mr-3 text-yellow-400"></i>
                            <div>
                                <div class="font-medium">Support Tickets</div>
                                <div class="text-white/60 text-xs">Submit a request</div>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item flex items-center px-4 py-3 text-white/90 text-sm">
                            <i class="fas fa-users mr-3 text-purple-400"></i>
                            <div>
                                <div class="font-medium">Community</div>
                                <div class="text-white/60 text-xs">Join discussions</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Right side items - Always visible -->
            <div class="flex items-center space-x-2 sm:space-x-4">
                <!-- Notifications - Hidden on small screens -->
                <div class="relative hidden md:block">
                    <button class="p-2 text-white/70 hover:text-white transition-colors relative">
                        <i class="fas fa-bell text-lg"></i>
                        <span class="notification-badge absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full"></span>
                    </button>
                </div>

                <!-- User Avatar -->
                <div class="hidden sm:flex items-center space-x-3 text-white">
                    <div class="text-right hidden md:block">
                        <div class="font-medium text-sm">{{ Auth::user()->username }}</div>
                        <div class="text-xs text-white/60">{{ Auth::user()->role}} Partner</div>
                    </div>
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500/30 to-purple-500/30 rounded-full flex items-center justify-center backdrop-blur-sm border border-white/20 cursor-pointer hover:scale-105 transition-transform">
                        <i class="fas fa-user text-white"></i>
                    </div>
                </div>

                <!-- Mobile Menu Button - Only visible on mobile/tablet -->
                <button @click="toggleMobileMenu()" class="lg:hidden p-2 text-white hover:bg-white/10 rounded-lg transition-colors">
                    <div class="hamburger w-6 h-6 flex flex-col justify-center space-y-1" :class="{'open': mobileMenuOpen}">
                        <div class="hamburger-line w-6 h-0.5 bg-white rounded"></div>
                        <div class="hamburger-line w-6 h-0.5 bg-white rounded"></div>
                        <div class="hamburger-line w-6 h-0.5 bg-white rounded"></div>
                    </div>
                </button>
            </div>
        </div>

        <!-- Mobile Menu - Slide from right -->
        <div class="mobile-menu fixed top-0 right-0 h-full w-80 max-w-[90vw] mobile-menu-bg z-50 lg:hidden"
             :class="{'open': mobileMenuOpen}"
             x-show="mobileMenuOpen"
             x-transition:enter="transition-transform ease-out duration-300"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition-transform ease-in duration-300"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full">
            <div class="p-6">
                <!-- Mobile menu header -->
                <div class="flex items-center justify-between mb-8">
                    <div class="text-lg font-bold text-white">
                        <i class="fas fa-rocket mr-2 gradient-text"></i>
                        <span class="gradient-text">Menu</span>
                    </div>
                    <button @click="toggleMobileMenu()" class="text-white p-2 hover:bg-white/10 rounded-lg transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- User info in mobile -->
                <div class="flex items-center space-x-3 text-white mb-6 p-4 mobile-user-info rounded-xl">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500/40 to-purple-500/40 rounded-full flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-user text-white text-lg"></i>
                    </div>
                    <div>
                        <div class="font-semibold text-base">John Doe</div>
                        <div class="text-sm text-white/70">Affiliate Partner</div>
                    </div>
                </div>

                <!-- Mobile menu items -->
                <div class="space-y-1">
                    <a href="#" @click="closeMobileMenu()" class="mobile-menu-item flex items-center p-4 transition-all">
                        <i class="fas fa-home mr-4 mobile-icon-home w-5"></i>
                        <span class="font-medium">Home</span>
                    </a>
                    
                    <a href="#" @click="closeMobileMenu()" class="mobile-menu-item flex items-center p-4 transition-all">
                        <i class="fas fa-box mr-4 mobile-icon-products w-5"></i>
                        <span class="font-medium">My Products</span>
                    </a>

                    <a href="#" @click="closeMobileMenu()" class="mobile-menu-item flex items-center p-4 transition-all">
                        <i class="fas fa-chart-bar mr-4 mobile-icon-analytics w-5"></i>
                        <span class="font-medium">Analytics</span>
                    </a>
                    
                    <div class="mobile-dropdown">
                        <button @click="toggleMobileDropdown('profile')" class="mobile-menu-item w-full flex items-center justify-between p-4 transition-all">
                            <div class="flex items-center">
                                <i class="fas fa-user mr-4 mobile-icon-profile w-5"></i>
                                <span class="font-medium">Profile</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-300" :class="{'rotate-180': mobileDropdowns.profile}"></i>
                        </button>
                        <div x-show="mobileDropdowns.profile" x-collapse class="ml-9 mt-1 space-y-1">
                            <a href="#" @click="closeMobileMenu()" class="mobile-dropdown-item block p-3 text-sm font-medium transition-all">My Profile</a>
                            <a href="#" @click="closeMobileMenu()" class="mobile-dropdown-item block p-3 text-sm font-medium transition-all">Earnings</a>
                            <a href="#" @click="closeMobileMenu()" class="mobile-dropdown-item block p-3 text-sm font-medium transition-all">Affiliate Links</a>
                            <a href="#" @click="closeMobileMenu()" class="mobile-dropdown-item block p-3 text-sm font-medium transition-all">Settings</a>
                        </div>
                    </div>
                    
                    <div class="mobile-dropdown">
                        <button @click="toggleMobileDropdown('help')" class="mobile-menu-item w-full flex items-center justify-between p-4 transition-all">
                            <div class="flex items-center">
                                <i class="fas fa-question-circle mr-4 mobile-icon-help w-5"></i>
                                <span class="font-medium">Help Center</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-300" :class="{'rotate-180': mobileDropdowns.help}"></i>
                        </button>
                        <div x-show="mobileDropdowns.help" x-collapse class="ml-9 mt-1 space-y-1">
                            <a href="#" @click="closeMobileMenu()" class="mobile-dropdown-item block p-3 text-sm font-medium transition-all">Documentation</a>
                            <a href="#" @click="closeMobileMenu()" class="mobile-dropdown-item block p-3 text-sm font-medium transition-all">Video Tutorials</a>
                            <a href="#" @click="closeMobileMenu()" class="mobile-dropdown-item block p-3 text-sm font-medium transition-all">Live Chat</a>
                            <a href="#" @click="closeMobileMenu()" class="mobile-dropdown-item block p-3 text-sm font-medium transition-all">Support Tickets</a>
                            <a href="#" @click="closeMobileMenu()" class="mobile-dropdown-item block p-3 text-sm font-medium transition-all">Community</a>
                        </div>
                    </div>

                    <!-- Notifications for mobile -->
                    <a href="#" @click="closeMobileMenu()" class="mobile-menu-item flex items-center p-4 transition-all md:hidden">
                        <i class="fas fa-bell mr-4 mobile-icon-notifications w-5"></i>
                        <span class="font-medium">Notifications</span>
                        <span class="notification-badge ml-auto w-3 h-3 bg-red-500 rounded-full"></span>
                    </a>

                    <div class="border-t border-white/20 my-6"></div>

                    <!-- Logout Form -->
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="mobile-logout-btn flex items-center p-4 rounded-xl transition-all w-full text-left border border-transparent">
                            <i class="fas fa-sign-out-alt mr-4 w-5"></i>
                            <span class="font-medium">Sign Out</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Overlay -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition-opacity ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="closeMobileMenu()" 
             class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 lg:hidden"></div>
    </nav>

    <script>
        function navbarData() {
            return {
                activeDropdown: null,
                mobileMenuOpen: false,
                mobileDropdowns: {
                    profile: false,
                    help: false
                },
                
                showDropdown(dropdown) {
                    this.activeDropdown = dropdown;
                },
                
                hideDropdown(dropdown) {
                    if (this.activeDropdown === dropdown) {
                        this.activeDropdown = null;
                    }
                },
                
                toggleMobileMenu() {
                    this.mobileMenuOpen = !this.mobileMenuOpen;
                    if (this.mobileMenuOpen) {
                        document.body.classList.add('mobile-menu-open');
                    } else {
                        document.body.classList.remove('mobile-menu-open');
                        // Close all mobile dropdowns when menu closes
                        this.mobileDropdowns.profile = false;
                        this.mobileDropdowns.help = false;
                    }
                },

                closeMobileMenu() {
                    this.mobileMenuOpen = false;
                    document.body.classList.remove('mobile-menu-open');
                    // Close all mobile dropdowns
                    this.mobileDropdowns.profile = false;
                    this.mobileDropdowns.help = false;
                },
                
                toggleMobileDropdown(dropdown) {
                    this.mobileDropdowns[dropdown] = !this.mobileDropdowns[dropdown];
                }}
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const navbar = document.querySelector('[x-data="navbarData()"]');
            if (navbar && !navbar.contains(event.target)) {
                const navbarData = Alpine.$data(navbar);
                if (navbarData && navbarData.mobileMenuOpen) {
                    navbarData.closeMobileMenu();
                }
            }
        });

        // Close dropdowns when pressing Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const navbar = document.querySelector('[x-data="navbarData()"]');
                if (navbar) {
                    const navbarData = Alpine.$data(navbar);
                    if (navbarData) {
                        navbarData.activeDropdown = null;
                        if (navbarData.mobileMenuOpen) {
                            navbarData.closeMobileMenu();
                        }
                    }
                }
            }
        });

        // Handle window resize to close mobile menu on desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) { // lg breakpoint
                const navbar = document.querySelector('[x-data="navbarData()"]');
                if (navbar) {
                    const navbarData = Alpine.$data(navbar);
                    if (navbarData && navbarData.mobileMenuOpen) {
                        navbarData.closeMobileMenu();
                    }
                }
            }
        });

        // Smooth scroll behavior for anchor links
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('a[href^="#"]');
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    if (href !== '#') {
                        const target = document.querySelector(href);
                        if (target) {
                            e.preventDefault();
                            target.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    }
                });
            });
        });

        // Add loading states for logout
        document.getElementById('logout-form')?.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-3"></i>Signing Out...';
                submitBtn.disabled = true;
            }
        });

        // Add notification click handler
        document.addEventListener('DOMContentLoaded', function() {
            const notificationBells = document.querySelectorAll('.fa-bell');
            notificationBells.forEach(bell => {
                bell.closest('button')?.addEventListener('click', function() {
                    // Remove the pulsing animation after click
                    const badge = this.querySelector('.notification-badge');
                    if (badge) {
                        badge.style.animation = 'none';
                        // You can add your notification handling logic here
                        console.log('Notifications clicked');
                    }
                });
            });
        });

        // Add search functionality (if you want to add a search feature later)
        function handleSearch(query) {
            if (query.trim()) {
                console.log('Searching for:', query);
                // Implement your search logic here
            }
        }

        // Add keyboard navigation for dropdowns
        document.addEventListener('keydown', function(event) {
            const activeDropdown = document.querySelector('.dropdown.show');
            if (activeDropdown && (event.key === 'ArrowDown' || event.key === 'ArrowUp')) {
                event.preventDefault();
                const items = activeDropdown.querySelectorAll('.dropdown-item');
                const currentFocus = document.activeElement;
                let currentIndex = Array.from(items).indexOf(currentFocus);
                
                if (event.key === 'ArrowDown') {
                    currentIndex = currentIndex < items.length - 1 ? currentIndex + 1 : 0;
                } else {
                    currentIndex = currentIndex > 0 ? currentIndex - 1 : items.length - 1;
                }
                
                items[currentIndex]?.focus();
            }
        });
    </script>

    <!-- Additional CSS for enhanced animations and effects -->
    <style>
        /* Enhanced loading states */
        .loading {
            pointer-events: none;
            opacity: 0.7;
        }

        /* Improved focus states for accessibility */
        .dropdown-item:focus,
        .mobile-menu-item:focus,
        .mobile-dropdown-item:focus {
            outline: 2px solid rgba(59, 130, 246, 0.5);
            outline-offset: 2px;
        }

        /* Enhanced notification effects */
        .notification-badge.read {
            animation: none;
            opacity: 0.6;
        }

        /* Improved mobile menu animations */
        @media (max-width: 1023px) {
            .mobile-menu-item {
                transform: translateX(20px);
                opacity: 0;
                animation: slideInLeft 0.3s ease forwards;
            }

            .mobile-menu-item:nth-child(1) { animation-delay: 0.1s; }
            .mobile-menu-item:nth-child(2) { animation-delay: 0.15s; }
            .mobile-menu-item:nth-child(3) { animation-delay: 0.2s; }
            .mobile-menu-item:nth-child(4) { animation-delay: 0.25s; }
            .mobile-menu-item:nth-child(5) { animation-delay: 0.3s; }
            .mobile-menu-item:nth-child(6) { animation-delay: 0.35s; }
        }

        @keyframes slideInLeft {
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Enhanced gradient text animation */
        .gradient-text {
            background-size: 200% 200%;
            animation: gradientShift 3s ease infinite;
        }

        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        /* Improved glassmorphism effects */
        .navbar-glass::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.03), transparent);
            pointer-events: none;
        }

        /* Enhanced dropdown shadows */
        .profile-dropdown {
            box-shadow: 
                0 20px 25px -5px rgba(0, 0, 0, 0.3),
                0 10px 10px -5px rgba(0, 0, 0, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        /* Better mobile transitions */
        .mobile-menu {
            box-shadow: -10px 0 30px rgba(0, 0, 0, 0.3);
        }

        /* Enhanced user avatar effects */
        .w-10.h-10.bg-gradient-to-br {
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
            transition: all 0.3s ease;
        }

        .w-10.h-10.bg-gradient-to-br:hover {
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
            transform: scale(1.05) translateY(-1px);
        }
    </style>