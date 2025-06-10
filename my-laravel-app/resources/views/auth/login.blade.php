<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Laravel App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js" defer></script>
    
    <style>
        :root {
            /* Gradient Colors */
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --indigo-gradient: linear-gradient(90deg, #6366f1 0%, #8b5cf6 100%);
            --success-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
            --warning-gradient: linear-gradient(135deg, #facc15 0%, #eab308 100%);
            --danger-gradient: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            
            /* Solid Colors */
            --primary-purple: #667eea;
            --primary-purple-dark: #764ba2;
            --indigo-500: #6366f1;
            --indigo-600: #4f46e5;
            --blue-500: #3b82f6;
            --blue-600: #2563eb;
            --yellow-400: #facc15;
            --yellow-500: #eab308;
            --green-500: #10b981;
            --green-600: #059669;
            --red-500: #ef4444;
            --red-600: #dc2626;
            --pink-500: #ec4899;
            --pink-600: #db2777;
            
            /* Neutral Colors */
            --white: #ffffff;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-400: #9ca3af;
            --gray-600: #6b7280;
            --gray-700: #374151;
            --gray-900: #111827;
            --black: #000000;
            
            /* Glassmorphism Effects */
            --glass-bg: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.2);
            --glass-blur: blur(10px);
            
            /* Text Colors */
            --text-primary: #ffffff;
            --text-primary-dark: #111827;
            --text-secondary: #e5e7eb;
            --text-secondary-dark: #6b7280;
            
            /* Background Colors */
            --bg-light: #ffffff;
            --bg-dark: #111827;
            --bg-gray: #f3f4f6;
            
            /* Status Colors */
            --success: #10b981;
            --warning: #facc15;
            --error: #ef4444;
            --info: #3b82f6;
        }

        .gradient-bg {
            background: var(--primary-gradient);
        }

        .glass-card {
            background: rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
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

        .floating-label {
            transform: translateY(-1.5rem) scale(0.75);
        }

        .input-focus {
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
        }

        .btn-primary {
            background: var(--indigo-gradient);
            position: relative;
            overflow: hidden;
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

        .password-strength {
            height: 4px;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .strength-weak { background: var(--red-500); width: 33%; }
        .strength-medium { background: var(--yellow-400); width: 66%; }
        .strength-strong { background: var(--green-500); width: 100%; }

        /* Custom checkbox styles */
        .custom-checkbox {
            appearance: none;
            width: 1.25rem;
            height: 1.25rem;
            border: 2px solid #d1d5db;
            border-radius: 0.25rem;
            background: white;
            position: relative;
            cursor: pointer;
            transition: all 0.2s;
        }

        .custom-checkbox:checked {
            background: var(--indigo-500);
            border-color: var(--indigo-500);
        }

        .custom-checkbox:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 0.875rem;
            font-weight: bold;
        }

        /* Animated background */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .floating-shape {
            animation: float 6s ease-in-out infinite;
        }

        .floating-shape:nth-child(2) {
            animation-delay: -2s;
        }

        .floating-shape:nth-child(3) {
            animation-delay: -4s;
        }
    </style>
</head>
<body class="min-h-screen gradient-bg relative overflow-hidden">
    <!-- Animated Background Shapes -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="floating-shape absolute top-20 left-10 w-32 h-32 bg-white/10 rounded-full blur-xl"></div>
        <div class="floating-shape absolute top-40 right-20 w-24 h-24 bg-purple-300/20 rounded-full blur-lg"></div>
        <div class="floating-shape absolute bottom-20 left-20 w-40 h-40 bg-indigo-300/10 rounded-full blur-2xl"></div>
        <div class="floating-shape absolute bottom-40 right-10 w-28 h-28 bg-pink-300/15 rounded-full blur-xl"></div>
    </div>

    <div class="container mx-auto px-4 py-4 relative z-10">
        <div class="flex justify-center items-start min-h-screen">
            <div class="w-full max-w-md my-4" data-aos="fade-up" data-aos-duration="800">
                <!-- Login Card -->
                <div class="glass-card rounded-2xl shadow-2xl backdrop-blur-lg max-h-[85vh] flex flex-col">
                    <!-- Scrollable Content -->
                    <div class="overflow-y-auto custom-scrollbar flex-1 p-6" x-data="loginForm()">
                        <!-- Header -->
                        <div class="text-center mb-6" data-aos="fade-down" data-aos-delay="200">
                            <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full mb-3">
                                <i class="fas fa-sign-in-alt text-white text-lg"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-white mb-1">Welcome Back</h2>
                            <p class="text-gray-300 text-sm">Sign in to your account</p>
                        </div>

                        <!-- Laravel Validation Errors -->
                        @if ($errors->any())
                            <div class="mb-4 p-3 bg-red-500/20 border border-red-400/30 rounded-lg text-red-100 text-sm">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                @if ($errors->count() == 1)
                                    {{ $errors->first() }}
                                @else
                                    <ul class="mt-2 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>• {{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @endif

                        <!-- Success Message -->
                        @if (session('status'))
                            <div class="mb-4 p-3 bg-green-500/20 border border-green-400/30 rounded-lg text-green-100 text-sm">
                                <i class="fas fa-check-circle mr-2"></i>
                                {{ session('status') }}
                            </div>
                        @endif

                        <!-- Laravel Login Form -->
                        <form method="POST" action="{{ route('login') }}" class="space-y-4" id="loginForm" @submit="handleSubmit">
                            @csrf
                            
                            <!-- Email Field -->
                            <div class="relative" data-aos="fade-left" data-aos-delay="300">
                                <div class="relative">
                                    <input type="email" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}"
                                           required
                                           autocomplete="email"
                                           autofocus
                                           x-model="form.email"
                                           @focus="focusField('email')"
                                           @blur="blurField('email')"
                                           class="w-full px-3 py-2.5 bg-black/20 border border-white/30 rounded-lg text-white placeholder-transparent focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all duration-300 peer @error('email') border-red-400 @enderror">
                                    <label for="email" 
                                           class="absolute left-3 top-2.5 text-gray-200 text-sm transition-all duration-300 peer-placeholder-shown:top-2.5 peer-placeholder-shown:text-sm peer-focus:-top-2 peer-focus:left-2 peer-focus:text-xs peer-focus:text-indigo-300 peer-focus:bg-black/60 peer-focus:px-2 peer-focus:rounded"
                                           :class="{'floating-label bg-black/60 px-2 rounded text-xs text-indigo-300': form.email || '{{ old('email') }}'}">
                                        <i class="fas fa-envelope mr-2"></i>Email Address
                                    </label>
                                </div>
                                @error('email')
                                    <div class="mt-2 text-red-400 text-sm flex items-center">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <!-- Password Field -->
                            <div class="relative" data-aos="fade-right" data-aos-delay="400">
                                <div class="relative">
                                    <input :type="showPassword ? 'text' : 'password'" 
                                           id="password" 
                                           name="password" 
                                           required
                                           autocomplete="current-password"
                                           x-model="form.password"
                                           @focus="focusField('password')"
                                           @blur="blurField('password')"
                                           class="w-full px-3 py-2.5 pr-12 bg-black/20 border border-white/30 rounded-lg text-white placeholder-transparent focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all duration-300 peer @error('password') border-red-400 @enderror">
                                    <label for="password" 
                                           class="absolute left-3 top-2.5 text-gray-200 text-sm transition-all duration-300 peer-placeholder-shown:top-2.5 peer-placeholder-shown:text-sm peer-focus:-top-2 peer-focus:left-2 peer-focus:text-xs peer-focus:text-indigo-300 peer-focus:bg-black/60 peer-focus:px-2 peer-focus:rounded"
                                           :class="{'floating-label bg-black/60 px-2 rounded text-xs text-indigo-300': form.password}">
                                        <i class="fas fa-lock mr-2"></i>Password
                                    </label>
                                    <button type="button" 
                                            @click="showPassword = !showPassword"
                                            class="absolute right-3 top-2.5 text-gray-400 hover:text-white transition-colors">
                                        <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                    </button>
                                </div>
                                
                                @error('password')
                                    <div class="mt-2 text-red-400 text-sm flex items-center">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="flex items-center justify-between" data-aos="fade-up" data-aos-delay="500">
                                <label class="flex items-center space-x-2 cursor-pointer group">
                                    <input type="checkbox" 
                                           name="remember" 
                                           id="remember"
                                           x-model="form.remember"
                                           {{ old('remember') ? 'checked' : '' }}
                                           class="custom-checkbox group-hover:border-indigo-400 transition-colors">
                                    <span class="text-sm text-gray-300">Remember Me</span>
                                </label>
                                
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-sm text-indigo-400 hover:text-indigo-300 underline underline-offset-2 transition-colors">
                                        Forgot Your Password?
                                    </a>
                                @endif
                            </div>

                            <!-- Submit Button -->
                            <div data-aos="fade-up" data-aos-delay="600">
                                <button type="submit" 
                                        class="w-full btn-primary text-white font-semibold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:hover:shadow-lg disabled:hover:translate-y-0"
                                        :disabled="isLoading"
                                        :class="{'opacity-50 cursor-not-allowed': isLoading}">
                                    <span x-show="!isLoading" class="flex items-center justify-center">
                                        <i class="fas fa-sign-in-alt mr-2"></i>
                                        Login
                                    </span>
                                    <span x-show="isLoading" class="flex items-center justify-center">
                                        <i class="fas fa-spinner fa-spin mr-2"></i>
                                        Signing In...
                                    </span>
                                </button>
                            </div>

                            <!-- Register Link -->
                            @if (Route::has('register'))
                                <div class="text-center" data-aos="fade-up" data-aos-delay="700">
                                    <p class="text-gray-300 text-sm">
                                        Don't have an account?
                                        <a href="{{ route('register') }}" class="text-indigo-400 hover:text-indigo-300 font-semibold underline underline-offset-2 transition-colors">
                                            Create one here
                                        </a>
                                    </p>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

   <script>
    // Initialize AOS
AOS.init({
    duration: 800,
    easing: 'ease-out-cubic',
    once: true
});

function loginForm() {
    return {
        form: {
            email: '',
            username: '',
            password: '',
            remember: false
        },
        errors: {
            email: '',
            password: ''
        },
        showPassword: false,
        isLoading: false,
        isSubmitted: false, // Track if form has been submitted
        successMessage: '',
        errorMessage: '',
        
        init() {
            // Force clear form on component initialization
            this.resetForm();
        },
        
        get isFormValid() {
            return this.form.email.length > 0 && 
                   this.form.password.length > 0 &&
                   this.isValidEmail(this.form.email) &&
                   !this.isSubmitted; // Prevent resubmission
        },
        
        isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        },
        
        validateForm() {
            this.errors = { email: '', password: '' };
            
            if (!this.form.email) {
                this.errors.email = 'Email is required';
            } else if (!this.isValidEmail(this.form.email)) {
                this.errors.email = 'Please enter a valid email address';
            }
            
            if (!this.form.password) {
                this.errors.password = 'Password is required';
            } else if (this.form.password.length < 6) {
                this.errors.password = 'Password must be at least 6 characters';
            }
            
            return !this.errors.email && !this.errors.password;
        },
        
        focusField(field) {
            // Clear error when user starts typing
            if (this.errors[field]) {
                this.errors[field] = '';
            }
        },
        
        blurField(field) {
            // Validate field on blur
            this.validateField(field);
        },
        
        validateField(field) {
            if (field === 'email' && this.form.email) {
                if (!this.isValidEmail(this.form.email)) {
                    this.errors.email = 'Please enter a valid email address';
                } else {
                    this.errors.email = '';
                }
            }
            
            if (field === 'password' && this.form.password) {
                if (this.form.password.length < 6) {
                    this.errors.password = 'Password must be at least 6 characters';
                } else {
                    this.errors.password = '';
                }
            }
        },
        
        resetForm() {
            // Reset Alpine.js data
            this.form = {
                email: '',
                username: '',
                password: '',
                remember: false
            };
            this.errors = { email: '', password: '' };
            this.successMessage = '';
            this.errorMessage = '';
            this.showPassword = false;
            this.isLoading = false;
            this.isSubmitted = false;
        },
        
        async handleSubmit() {
            if (!this.validateForm() || this.isSubmitted) {
                return;
            }
            
            this.isLoading = true;
            this.isSubmitted = true; // Prevent multiple submissions
            this.errorMessage = '';
            this.successMessage = '';
            
            try {
                // Simulate API call
                await new Promise(resolve => setTimeout(resolve, 2000));
                
                // Mock successful login
                if (this.form.email === 'demo@example.com' && this.form.password === 'password') {
                    this.successMessage = 'Login successful! Redirecting...';
                    
                    setTimeout(() => {
                        // Clear form before redirect
                        this.resetForm();
                        // Redirect to home
                        window.location.href = '/home';
                    }, 1500);
                } else {
                    this.errorMessage = 'Invalid email or password. Please try again.';
                    this.isSubmitted = false; // Allow retry on error
                }
            } catch (error) {
                this.errorMessage = 'An error occurred. Please try again later.';
                this.isSubmitted = false; // Allow retry on error
            } finally {
                this.isLoading = false;
            }
        }
    }
}

// Reset form state if user navigates back - same as your registration
window.addEventListener('pageshow', function(event) {
    if (event.persisted) {
        // Page was loaded from cache, reload to ensure fresh state
        window.location.reload();
    }
});
   </script>
</body>
</html>