<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leap Affiliate - Transform Your Earnings</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        .typing-animation {
            overflow: hidden;
            border-right: .15em solid #667eea;
            white-space: nowrap;
            margin: 0 auto;
            animation: typing 3.5s steps(40, end), blink-caret .75s step-end infinite;
        }
        @keyframes typing {
            from { width: 0 }
            to { width: 100% }
        }
        @keyframes blink-caret {
            from, to { border-color: transparent }
            50% { border-color: #667eea; }
        }
        .glassmorphism {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="bg-gray-50">
    
    <!-- Navigation -->
    <nav class="fixed w-full z-50 bg-white/80 backdrop-blur-md shadow-lg" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <i class="fas fa-rocket text-2xl text-purple-600 mr-2"></i>
                        <span class="text-2xl font-bold gradient-text bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">Leap Affiliate</span>
                    </div>
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
    <a href="#features" class="text-gray-700 hover:text-purple-600 transition duration-300">Features</a>
    <a href="#pricing" class="text-gray-700 hover:text-purple-600 transition duration-300">Pricing</a>
    <a href="#testimonials" class="text-gray-700 hover:text-purple-600 transition duration-300">Success Stories</a>
    <a href="{{ route('register') }}" class="text-gray-700 hover:text-purple-600 transition duration-300">Contact</a>
    <a href="{{ route('register') }}" class="bg-purple-600 text-white px-6 py-2 rounded-full hover:bg-purple-700 transition duration-300">
        Get Started
    </a>
</div>
                <div class="md:hidden flex items-center">
                    <button @click="open = !open" class="text-gray-700">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
        
       <div x-show="open" class="md:hidden bg-white shadow-lg">
    <div class="px-2 pt-2 pb-3 space-y-1">
        <a href="#features" class="block px-3 py-2 text-gray-700">Features</a>
        <a href="#pricing" class="block px-3 py-2 text-gray-700">Pricing</a>
        <a href="#testimonials" class="block px-3 py-2 text-gray-700">Success Stories</a>
        <a href="#contact" class="block px-3 py-2 text-gray-700">Contact</a>
        <a href="{{ route('register') }}" class="w-full block text-left bg-purple-600 text-white px-3 py-2 rounded">Get Started</a>
    </div>
</div>
    </nav>

    <!-- Hero Section -->
    <section class="gradient-bg min-h-screen flex items-center relative overflow-hidden pt-16">
        <div class="absolute inset-0">
            <div class="absolute top-20 left-10 w-72 h-72 bg-white/10 rounded-full blur-3xl float-animation"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl float-animation" style="animation-delay: -3s;"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="text-white" data-aos="fade-right">
                    <h1 class="text-5xl lg:text-7xl font-bold mb-6 leading-tight">
                        Transform Your
                        <span class="typing-animation block text-yellow-300">Affiliate Journey</span>
                    </h1>
                    <p class="text-xl mb-8 text-gray-100 leading-relaxed">
                        Join thousands of successful affiliates earning $10K+ monthly with our advanced marketing platform. Track, optimize, and scale your campaigns like never before.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button class="bg-yellow-400 text-gray-900 px-8 py-4 rounded-full font-semibold text-lg hover:bg-yellow-300 transition duration-300 transform hover:scale-105">
                            Start Free Trial
                        </button>
                        <button class="border-2 border-white text-white px-8 py-4 rounded-full font-semibold text-lg hover:bg-white hover:text-gray-900 transition duration-300">
                            Watch Demo
                        </button>
                    </div>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-8 mt-12">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-yellow-300">50K+</div>
                            <div class="text-sm text-gray-200">Active Affiliates</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-yellow-300">$2.5M</div>
                            <div class="text-sm text-gray-200">Monthly Payouts</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-yellow-300">98%</div>
                            <div class="text-sm text-gray-200">Success Rate</div>
                        </div>
                    </div>
                </div>
                
                <div class="relative" data-aos="fade-left">
                    <div class="glassmorphism rounded-2xl p-8 relative">
                        <div class="bg-white rounded-xl p-6 shadow-2xl">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-800">Live Dashboard</h3>
                                <div class="flex space-x-2">
                                    <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                                    <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                                    <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Today's Earnings</span>
                                    <span class="text-2xl font-bold text-green-600">$1,247</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Clicks</span>
                                    <span class="text-lg font-semibold">2,340</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Conversion Rate</span>
                                    <span class="text-lg font-semibold text-blue-600">8.2%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-purple-600 to-blue-600 h-2 rounded-full pulse-animation" style="width: 78%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Powerful Features for Maximum ROI</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Everything you need to succeed in affiliate marketing, from advanced analytics to automated optimization.</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="card-hover bg-gradient-to-br from-purple-50 to-blue-50 p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 bg-purple-600 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-chart-line text-2xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Real-Time Analytics</h3>
                    <p class="text-gray-600 mb-6">Track your performance with advanced analytics and real-time reporting. See which campaigns convert best.</p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Live conversion tracking</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Revenue attribution</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Custom dashboards</li>
                    </ul>
                </div>
                
                <div class="card-hover bg-gradient-to-br from-green-50 to-teal-50 p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 bg-green-600 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-robot text-2xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">AI Optimization</h3>
                    <p class="text-gray-600 mb-6">Let our AI automatically optimize your campaigns for maximum conversions and revenue.</p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Smart bid management</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Audience targeting</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>A/B test automation</li>
                    </ul>
                </div>
                
                <div class="card-hover bg-gradient-to-br from-yellow-50 to-orange-50 p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-16 h-16 bg-yellow-600 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-link text-2xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Smart Link Management</h3>
                    <p class="text-gray-600 mb-6">Create, manage, and track thousands of affiliate links with our intelligent link management system.</p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Link cloaking & branding</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Geographic redirects</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Mobile optimization</li>
                    </ul>
                </div>
                
                <div class="card-hover bg-gradient-to-br from-pink-50 to-red-50 p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="400">
                    <div class="w-16 h-16 bg-pink-600 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-dollar-sign text-2xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Instant Payouts</h3>
                    <p class="text-gray-600 mb-6">Get paid instantly with our flexible payout system. Multiple payment methods available.</p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Daily payouts available</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Multiple currencies</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Tax reporting tools</li>
                    </ul>
                </div>
                
                <div class="card-hover bg-gradient-to-br from-indigo-50 to-purple-50 p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="500">
                    <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-users text-2xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Team Collaboration</h3>
                    <p class="text-gray-600 mb-6">Work with your team seamlessly. Share campaigns, insights, and optimize together.</p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Team workspaces</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Permission management</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Shared reporting</li>
                    </ul>
                </div>
                
                <div class="card-hover bg-gradient-to-br from-teal-50 to-cyan-50 p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="600">
                    <div class="w-16 h-16 bg-teal-600 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-shield-alt text-2xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Fraud Protection</h3>
                    <p class="text-gray-600 mb-6">Advanced fraud detection keeps your campaigns safe and your ROI protected.</p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Click fraud detection</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Bot traffic filtering</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Quality score monitoring</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Choose Your Success Plan</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Start free and scale as you grow. No hidden fees, no commitments.</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- Starter Plan -->
                <div class="bg-white rounded-2xl p-8 shadow-lg card-hover" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Starter</h3>
                        <div class="text-4xl font-bold text-gray-900 mb-2">Free</div>
                        <p class="text-gray-600">Perfect for beginners</p>
                    </div>
                    
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Up to 1,000 clicks/month</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Basic analytics</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>5 affiliate links</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Email support</li>
                        <li class="flex items-center text-gray-400"><i class="fas fa-times mr-3"></i>AI optimization</li>
                    </ul>
                    
                    <button class="w-full bg-gray-900 text-white py-3 rounded-lg hover:bg-gray-800 transition duration-300">
                        Get Started Free
                    </button>
                </div>
                
                <!-- Pro Plan -->
                <div class="bg-gradient-to-br from-purple-600 to-blue-600 rounded-2xl p-8 shadow-2xl card-hover relative" data-aos="fade-up" data-aos-delay="200">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                        <span class="bg-yellow-400 text-gray-900 px-4 py-1 rounded-full text-sm font-semibold">Most Popular</span>
                    </div>
                    
                    <div class="text-center mb-8 text-white">
                        <h3 class="text-2xl font-bold mb-2">Pro</h3>
                        <div class="text-4xl font-bold mb-2">$49<span class="text-lg">/month</span></div>
                        <p class="text-purple-100">For growing affiliates</p>
                    </div>
                    
                    <ul class="space-y-4 mb-8 text-white">
                        <li class="flex items-center"><i class="fas fa-check text-yellow-400 mr-3"></i>Unlimited clicks</li>
                        <li class="flex items-center"><i class="fas fa-check text-yellow-400 mr-3"></i>Advanced analytics</li>
                        <li class="flex items-center"><i class="fas fa-check text-yellow-400 mr-3"></i>Unlimited links</li>
                        <li class="flex items-center"><i class="fas fa-check text-yellow-400 mr-3"></i>AI optimization</li>
                        <li class="flex items-center"><i class="fas fa-check text-yellow-400 mr-3"></i>Priority support</li>
                        <li class="flex items-center"><i class="fas fa-check text-yellow-400 mr-3"></i>Team collaboration</li>
                    </ul>
                    
                    <button class="w-full bg-yellow-400 text-gray-900 py-3 rounded-lg hover:bg-yellow-300 transition duration-300 font-semibold">
                        Start Pro Trial
                    </button>
                </div>
                
                <!-- Enterprise Plan -->
                <div class="bg-white rounded-2xl p-8 shadow-lg card-hover" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Enterprise</h3>
                        <div class="text-4xl font-bold text-gray-900 mb-2">$199<span class="text-lg">/month</span></div>
                        <p class="text-gray-600">For agencies & teams</p>
                    </div>
                    
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Everything in Pro</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>White-label solution</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>API access</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Custom integrations</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Dedicated manager</li>
                    </ul>
                    
                    <button class="w-full bg-gray-900 text-white py-3 rounded-lg hover:bg-gray-800 transition duration-300">
                        Contact Sales
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Success Stories</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">See how our platform has transformed affiliate careers worldwide.</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-8 rounded-2xl card-hover" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center mb-6">
                        <img src="https://images.unsplash.com/photo-1494790108755-2616b612b732?w=60&h=60&fit=crop&crop=face" 
                             alt="Sarah Johnson" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="font-semibold text-gray-900">Sarah Johnson</h4>
                            <p class="text-sm text-gray-600">Digital Marketer</p>
                        </div>
                    </div>
                    <div class="flex mb-4">
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                    </div>
                    <p class="text-gray-700 mb-4">"Leap Affiliate increased my monthly earnings by 340% in just 3 months. The AI optimization is incredible!"</p>
                    <div class="text-2xl font-bold text-green-600">$15,000/month</div>
                </div>
                
                <div class="bg-gradient-to-br from-green-50 to-teal-50 p-8 rounded-2xl card-hover" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center mb-6">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=60&h=60&fit=crop&crop=face" 
                             alt="Michael Chen" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="font-semibold text-gray-900">Michael Chen</h4>
                            <p class="text-sm text-gray-600">Affiliate Manager</p>
                        </div>
                    </div>
                    <div class="flex mb-4">
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                    </div>
                    <p class="text-gray-700 mb-4">"Managing 50+ campaigns has never been easier. The analytics are phenomenal and save me 20 hours per week."</p>
                    <div class="text-2xl font-bold text-green-600">$32,000/month</div>
                </div>
                
                <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-8 rounded-2xl card-hover" data-aos="fade-up" data-aos-delay="300">
                    <div class="flex items-center mb-6">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=60&h=60&fit=crop&crop=face" 
                             alt="Emily Rodriguez" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="font-semibold text-gray-900">Emily Rodriguez</h4>
                            <p class="text-sm text-gray-600">Content Creator</p>
                        </div>
                    </div>
                    <div class="flex mb-4">
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                    </div>
                    <p class="text-gray-700 mb-4">"From $500 to $8,000 monthly in 6 months. The fraud protection alone saved me thousands!"</p>
                    <div class="text-2xl font-bold text-green-600">$8,000/month</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 gradient-bg relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute top-10 right-10 w-64 h-64 bg-white/10 rounded-full blur-3xl float-animation"></div>
            <div class="absolute bottom-10 left-10 w-48 h-48 bg-yellow-400/20 rounded-full blur-3xl float-animation" style="animation-delay: -2s;"></div>
        </div>
        
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10" data-aos="fade-up">
            <h2 class="text-4xl lg:text-5xl font-bold text-white mb-6">Ready to 10X Your Affiliate Income?</h2>
            <p class="text-xl text-gray-100 mb-8 max-w-2xl mx-auto">
                Join 50,000+ successful affiliates who've transformed their earnings with our platform. Start your free trial today!
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                <button class="bg-yellow-400 text-gray-900 px-8 py-4 rounded-full font-semibold text-lg hover:bg-yellow-300 transition duration-300 transform hover:scale-105">
                    Start Free Trial - No Credit Card Required
                </button>
                <button class="border-2 border-white text-white px-8 py-4 rounded-full font-semibold text-lg hover:bg-white hover:text-gray-900 transition duration-300">
                    Schedule Demo Call
                </button>
            </div>
            
            <div class="flex items-center justify-center space-x-8 text-white/80">
                <div class="flex items-center">
                    <i class="fas fa-shield-alt mr-2"></i>
                    <span>SSL Secured</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-credit-card mr-2"></i>
                    <span>No Setup Fees</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-clock mr-2"></i>
                    <span>24/7 Support</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-12">
                <div class="col-span-1">
                    <div class="flex items-center mb-6">
                        <i class="fas fa-rocket text-2xl text-purple-400 mr-2"></i>
                        <span class="text-2xl font-bold">Leap Affiliate</span>
                    </div>
                    <p class="text-gray-400 mb-6">
                        The world's most advanced affiliate marketing platform. Transform your earnings today.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                            <i class="fab fa-linkedin text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-6">Platform</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li><a href="#" class="hover:text-white transition duration-300">Features</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Pricing</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">API Documentation</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Integrations</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Security</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-6">Resources</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li><a href="#" class="hover:text-white transition duration-300">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Case Studies</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Help Center</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Webinars</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Community</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-6">Company</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li><a href="#" class="hover:text-white transition duration-300">About Us</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Careers</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Press</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Contact</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Partners</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="text-gray-400 mb-4 md:mb-0">
                        © 2025 Leap Affiliate. All rights reserved.
                    </div>
                    <div class="flex space-x-6 text-gray-400">
                        <a href="#" class="hover:text-white transition duration-300">Privacy Policy</a>
                        <a href="#" class="hover:text-white transition duration-300">Terms of Service</a>
                        <a href="#" class="hover:text-white transition duration-300">Cookie Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Initialize AOS (Animate On Scroll)
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 1000,
                once: true,
                offset: 100
            });

            // Smooth scrolling for navigation links
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

            // Dynamic typing animation for hero text
            const typingText = document.querySelector('.typing-animation');
            if (typingText) {
                const words = ['Affiliate Journey', 'Revenue Stream', 'Marketing Game', 'Income Potential'];
                let wordIndex = 0;
                let charIndex = 0;
                let isDeleting = false;

                function typeWords() {
                    const currentWord = words[wordIndex];
                    
                    if (isDeleting) {
                        typingText.textContent = currentWord.substring(0, charIndex - 1);
                        charIndex--;
                    } else {
                        typingText.textContent = currentWord.substring(0, charIndex + 1);
                        charIndex++;
                    }

                    if (!isDeleting && charIndex === currentWord.length) {
                        setTimeout(() => isDeleting = true, 2000);
                    } else if (isDeleting && charIndex === 0) {
                        isDeleting = false;
                        wordIndex = (wordIndex + 1) % words.length;
                    }

                    const typingSpeed = isDeleting ? 100 : 150;
                    setTimeout(typeWords, typingSpeed);
                }

                setTimeout(typeWords, 1000);
            }

            // Add scroll effect to navigation
            window.addEventListener('scroll', function() {
                const nav = document.querySelector('nav');
                if (window.scrollY > 100) {
                    nav.classList.add('bg-white/90');
                    nav.classList.remove('bg-white/80');
                } else {
                    nav.classList.add('bg-white/80');
                    nav.classList.remove('bg-white/90');
                }
            });

            // Counter animation for stats
            function animateCounters() {
                const counters = document.querySelectorAll('.text-3xl.font-bold.text-yellow-300');
                
                counters.forEach(counter => {
                    const target = counter.textContent;
                    const numericTarget = parseInt(target.replace(/[^\d]/g, ''));
                    let current = 0;
                    const increment = numericTarget / 100;
                    
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= numericTarget) {
                            counter.textContent = target;
                            clearInterval(timer);
                        } else {
                            if (target.includes('K')) {
                                counter.textContent = Math.floor(current) + 'K+';
                            } else if (target.includes('M')) {
                                counter.textContent = '$' + (current / 1000000).toFixed(1) + 'M';
                            } else if (target.includes('%')) {
                                counter.textContent = Math.floor(current) + '%';
                            }
                        }
                    }, 50);
                });
            }

            // Trigger counter animation when hero section is visible
            const heroSection = document.querySelector('.gradient-bg');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateCounters();
                        observer.unobserve(entry.target);
                    }
                });
            });

            observer.observe(heroSection);

            // Add interactive hover effects
            const cards = document.querySelectorAll('.card-hover');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-10px) scale(1.02)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Add click ripple effect to buttons
            const buttons = document.querySelectorAll('button');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;
                    
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';
                    ripple.classList.add('ripple');
                    
                    this.appendChild(ripple);
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });
    </script>

    <style>
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
            pointer-events: none;
        }

        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        /* Additional responsive improvements */
        @media (max-width: 768px) {
            .typing-animation {
                font-size: 2.5rem;
            }
            
            .text-5xl.lg\:text-7xl {
                font-size: 2.5rem;
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
        }
    </style>

</body>
</html>