
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Laravel App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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

        /* Custom select styles */
        .custom-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }

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
<body class="min-h-screen gradient-bg relative overflow-hidden" x-data="registrationForm()">
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
                <!-- Registration Card -->
                <div class="glass-card rounded-2xl shadow-2xl backdrop-blur-lg max-h-[90vh] flex flex-col">
                    <!-- Scrollable Content -->
                    <div class="overflow-y-auto custom-scrollbar flex-1 p-6 pb-4">
                        <!-- Header -->
                        <div class="text-center mb-6" data-aos="fade-down" data-aos-delay="200">
                            <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full mb-3">
                                <i class="fas fa-user-plus text-white text-lg"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-white mb-1">Create Account</h2>
                            <p class="text-gray-300 text-sm">Join us today</p>
                        </div>

                        <!-- Success Message -->
                        @if(session('success'))
                            <div class="mb-4 p-3 bg-green-500/20 border border-green-400/30 rounded-lg text-green-100 text-sm" data-aos="fade-in">
                                <i class="fas fa-check-circle mr-2"></i>
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Registration Form -->
                        <form method="POST" action="{{ route('register') }}" @submit="handleSubmit" class="space-y-4" id="registrationForm">
                            @csrf
                            
                            <!-- Name Field -->
                            <div class="relative" data-aos="fade-left" data-aos-delay="300">
                                <div class="relative">
                                    <input type="text" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}"
                                           required
                                           autocomplete="name"
                                           autofocus
                                           x-model="form.name"
                                           @focus="focusField('name')"
                                           @blur="blurField('name')"
                                           class="w-full px-3 py-2.5 bg-black/20 border border-white/30 rounded-lg text-white placeholder-transparent focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all duration-300 peer @error('name') border-red-400 @enderror">
                                    <label for="name" 
                                           class="absolute left-3 top-2.5 text-gray-200 text-sm transition-all duration-300 peer-placeholder-shown:top-2.5 peer-placeholder-shown:text-sm peer-focus:-top-2 peer-focus:left-2 peer-focus:text-xs peer-focus:text-indigo-300 peer-focus:bg-black/60 peer-focus:px-2 peer-focus:rounded"
                                           :class="{'floating-label bg-black/60 px-2 rounded text-xs text-indigo-300': form.name}">
                                        <i class="fas fa-user mr-2"></i>Full Name
                                    </label>
                                </div>
                                @error('name')
                                    <div class="mt-2 text-red-400 text-sm flex items-center">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Username Field -->
                            <div class="relative" data-aos="fade-right" data-aos-delay="350">
                                <div class="relative">
                                    <input type="text" 
                                           id="username" 
                                           name="username" 
                                           value="{{ old('username') }}"
                                           required
                                           autocomplete="username"
                                           x-model="form.username"
                                           @focus="focusField('username')"
                                           @blur="blurField('username')"
                                           @input="validateUsername"
                                           class="w-full px-3 py-2.5 bg-black/20 border border-white/30 rounded-lg text-white placeholder-transparent focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all duration-300 peer @error('username') border-red-400 @enderror">
                                    <label for="username" 
                                           class="absolute left-3 top-2.5 text-gray-200 text-sm transition-all duration-300 peer-placeholder-shown:top-2.5 peer-placeholder-shown:text-sm peer-focus:-top-2 peer-focus:left-2 peer-focus:text-xs peer-focus:text-indigo-300 peer-focus:bg-black/60 peer-focus:px-2 peer-focus:rounded"
                                           :class="{'floating-label bg-black/60 px-2 rounded text-xs text-indigo-300': form.username}">
                                        <i class="fas fa-at mr-2"></i>Username
                                    </label>
                                </div>
                                <div x-show="usernameAvailable !== null" class="mt-2 text-sm flex items-center" :class="usernameAvailable ? 'text-green-400' : 'text-red-400'">
                                    <i :class="usernameAvailable ? 'fas fa-check-circle' : 'fas fa-exclamation-circle'" class="mr-2"></i>
                                    <span x-text="usernameAvailable ? 'Username is available' : 'Username is taken'"></span>
                                </div>
                                @error('username')
                                    <div class="mt-2 text-red-400 text-sm flex items-center">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div class="relative" data-aos="fade-left" data-aos-delay="400">
                                <div class="relative">
                                    <input type="email" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}"
                                           required
                                           autocomplete="email"
                                           x-model="form.email"
                                           @focus="focusField('email')"
                                           @blur="blurField('email')"
                                           class="w-full px-3 py-2.5 bg-black/20 border border-white/30 rounded-lg text-white placeholder-transparent focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all duration-300 peer @error('email') border-red-400 @enderror">
                                    <label for="email" 
                                           class="absolute left-3 top-2.5 text-gray-200 text-sm transition-all duration-300 peer-placeholder-shown:top-2.5 peer-placeholder-shown:text-sm peer-focus:-top-2 peer-focus:left-2 peer-focus:text-xs peer-focus:text-indigo-300 peer-focus:bg-black/60 peer-focus:px-2 peer-focus:rounded"
                                           :class="{'floating-label bg-black/60 px-2 rounded text-xs text-indigo-300': form.email}">
                                        <i class="fas fa-envelope mr-2"></i>Email Address
                                    </label>
                                </div>
                                @error('email')
                                    <div class="mt-2 text-red-400 text-sm flex items-center">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Role Field -->
                            <div class="relative" data-aos="fade-right" data-aos-delay="450">
                                <div class="relative">
                                    <select id="role" 
                                            name="role" 
                                            required
                                            x-model="form.role"
                                            @focus="focusField('role')"
                                            @blur="blurField('role')"
                                            class="custom-select w-full px-3 py-2.5 bg-black/20 border border-white/30 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all duration-300 @error('role') border-red-400 @enderror">
                                        <option value="" class="bg-gray-800 text-gray-400">Select Role</option>
                                        <option value="affiliate" class="bg-gray-800 text-white" {{ old('role') == 'affiliate' ? 'selected' : '' }}>Affiliate</option>
                                        <option value="vendor" class="bg-gray-800 text-white" {{ old('role') == 'vendor' ? 'selected' : '' }}>Vendor</option>
                                    </select>
                                    <label for="role" 
                                           class="absolute left-3 -top-2 bg-black/60 px-2 rounded text-xs text-indigo-300 transition-all duration-300"
                                           :class="{'text-gray-200 top-2.5 text-sm bg-transparent px-0': !form.role}">
                                        <i class="fas fa-user-tag mr-2"></i>Role
                                    </label>
                                </div>
                                @error('role')
                                    <div class="mt-2 text-red-400 text-sm flex items-center">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Password Field -->
                            <div class="relative" data-aos="fade-left" data-aos-delay="500">
                                <div class="relative">
                                    <input :type="showPassword ? 'text' : 'password'" 
                                           id="password" 
                                           name="password" 
                                           required
                                           autocomplete="new-password"
                                           x-model="form.password"
                                           @focus="focusField('password')"
                                           @blur="blurField('password')"
                                           @input="checkPasswordStrength"
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
                                
                                <!-- Password Strength Indicator -->
                                <div x-show="form.password.length > 0" class="mt-2">
                                    <div class="password-strength" :class="passwordStrengthClass"></div>
                                    <div class="text-xs text-gray-300 mt-1" x-text="passwordStrengthText"></div>
                                </div>
                                
                                @error('password')
                                    <div class="mt-2 text-red-400 text-sm flex items-center">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Confirm Password Field -->
                            <div class="relative" data-aos="fade-right" data-aos-delay="550">
                                <div class="relative">
                                    <input :type="showConfirmPassword ? 'text' : 'password'" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           required
                                           autocomplete="new-password"
                                           x-model="form.password_confirmation"
                                           @focus="focusField('password_confirmation')"
                                           @blur="blurField('password_confirmation')"
                                           class="w-full px-3 py-2.5 pr-12 bg-black/20 border border-white/30 rounded-lg text-white placeholder-transparent focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all duration-300 peer"
                                           :class="{'border-red-400': form.password_confirmation && form.password !== form.password_confirmation, 'border-green-400': form.password_confirmation && form.password === form.password_confirmation}">
                                    <label for="password_confirmation" 
                                           class="absolute left-3 top-2.5 text-gray-200 text-sm transition-all duration-300 peer-placeholder-shown:top-2.5 peer-placeholder-shown:text-sm peer-focus:-top-2 peer-focus:left-2 peer-focus:text-xs peer-focus:text-indigo-300 peer-focus:bg-black/60 peer-focus:px-2 peer-focus:rounded"
                                           :class="{'floating-label bg-black/60 px-2 rounded text-xs text-indigo-300': form.password_confirmation}">
                                        <i class="fas fa-lock mr-2"></i>Confirm Password
                                    </label>
                                    <button type="button" 
                                            @click="showConfirmPassword = !showConfirmPassword"
                                            class="absolute right-3 top-2.5 text-gray-400 hover:text-white transition-colors">
                                        <i :class="showConfirmPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                    </button>
                                </div>
                                
                                <!-- Password Match Indicator -->
                                <div x-show="form.password_confirmation.length > 0" class="mt-2 text-sm flex items-center" :class="form.password === form.password_confirmation ? 'text-green-400' : 'text-red-400'">
                                    <i :class="form.password === form.password_confirmation ? 'fas fa-check-circle' : 'fas fa-exclamation-circle'" class="mr-2"></i>
                                    <span x-text="form.password === form.password_confirmation ? 'Passwords match' : 'Passwords do not match'"></span>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Fixed Button Area -->
                    <div class="border-t border-white/20 p-4 bg-black/40 backdrop-blur-sm">
                        <button type="submit" 
                                form="registrationForm"
                                class="w-full btn-primary text-white font-semibold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                                :disabled="!isFormValid"
                                :class="{'opacity-50 cursor-not-allowed': !isFormValid}">
                            <span x-show="!isLoading" class="flex items-center justify-center">
                                <i class="fas fa-user-plus mr-2"></i>
                                Create Account
                            </span>
                            <span x-show="isLoading" class="flex items-center justify-center">
                                <i class="fas fa-spinner fa-spin mr-2"></i>
                                Creating Account...
                            </span>
                        </button>
                        
                        <!-- Login Link -->
                        <div class="text-center mt-3">
                            <p class="text-gray-300 text-sm">
                                Already have an account? 
                                <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300 font-semibold underline underline-offset-2 transition-colors">
                                    Sign in here
                                </a>
                            </p>
                        </div>
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

function registrationForm() {
    return {
        form: {
            name: '',
            username: '',
            email: '',
            role: '',
            password: '',
            password_confirmation: ''
        },
        showPassword: false,
        showConfirmPassword: false,
        isLoading: false,
        isSubmitted: false, // Track if form has been submitted
        passwordStrength: 0,
        usernameAvailable: null,
        
        get isFormValid() {
            return this.form.name.length > 0 && 
                   this.form.username.length > 0 && 
                   this.form.email.length > 0 && 
                   this.form.role.length > 0 && 
                   this.form.password.length >= 6 &&
                   this.form.password === this.form.password_confirmation &&
                   !this.isSubmitted; // Prevent resubmission
        },
        
        get passwordStrengthClass() {
            if (this.passwordStrength < 3) return 'strength-weak';
            if (this.passwordStrength < 5) return 'strength-medium';
            return 'strength-strong';
        },
        
        get passwordStrengthText() {
            if (this.passwordStrength < 3) return 'Weak password';
            if (this.passwordStrength < 5) return 'Medium strength';
            return 'Strong password';
        },
        
        focusField(field) {
            // Add focus animations or effects here
        },
        
        blurField(field) {
            // Add blur animations or effects here
        },
        
        checkPasswordStrength() {
            let strength = 0;
            const password = this.form.password;
            
            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            
            this.passwordStrength = strength;
        },
        
        validateUsername() {
            // Don't check username if form is already submitted
            if (this.isSubmitted) return;
            
            // Simulate username availability check
            // In real implementation, make an AJAX call to check availability
            if (this.form.username.length > 2) {
                setTimeout(() => {
                    // Random simulation - replace with actual API call
                    this.usernameAvailable = Math.random() > 0.3;
                }, 500);
            } else {
                this.usernameAvailable = null;
            }
        },
        
        handleSubmit(event) {
            if (!this.isFormValid || this.isSubmitted) {
                event.preventDefault();
                return;
            }
            
            this.isLoading = true;
            this.isSubmitted = true; // Mark as submitted to prevent multiple submissions
            
            // Reset loading state after a timeout in case of errors
            // This allows user to retry if something goes wrong
            setTimeout(() => {
                if (this.isLoading) {
                    this.isLoading = false;
                    // Don't reset isSubmitted here to prevent multiple submissions
                }
            }, 10000); // 10 second timeout
            
            // The form will submit naturally to Laravel
            // Laravel will handle redirect and error display
        }
    }
}

// Reset form state if user navigates back
window.addEventListener('pageshow', function(event) {
    if (event.persisted) {
        // Page was loaded from cache, reset the form state
        if (window.Alpine && window.Alpine.store) {
            // Reset any Alpine stores if needed
        }
        // Or reload the page to ensure fresh state
        window.location.reload();
    }
});
   </script>
    
   </body>
</html>