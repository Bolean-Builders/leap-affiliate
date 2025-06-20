@extends('layouts.app')

@section('title', 'Payment Methods')

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

    * {
        font-family: 'Inter', sans-serif;
    }

    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        transition: all 0.3s ease;
    }

    .glass-card:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-2px);
        box-shadow: 0 12px 40px 0 rgba(31, 38, 135, 0.5);
    }

    .gradient-btn {
        background: var(--indigo-gradient);
        transition: all 0.3s ease;
        border: none;
    }

    .gradient-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(99, 102, 241, 0.4);
    }

    .gradient-success {
        background: var(--success-gradient);
    }

    .gradient-warning {
        background: var(--warning-gradient);
    }

    .gradient-danger {
        background: var(--danger-gradient);
    }

    .floating-animation {
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .pulse-glow {
        animation: pulse-glow 2s infinite;
    }

    @keyframes pulse-glow {
        0%, 100% { box-shadow: 0 0 20px rgba(99, 102, 241, 0.5); }
        50% { box-shadow: 0 0 40px rgba(99, 102, 241, 0.8); }
    }

    .modal-backdrop {
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(10px);
    }

    .gradient-text {
        background: var(--indigo-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .method-icon-bg {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
    }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8" data-aos="fade-down">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Payment Methods</h1>
            <p class="text-white/80">Manage your payout methods and preferences</p>
        </div>
        <button onclick="openCreateModal()" 
                class="gradient-btn text-white px-6 py-3 rounded-xl font-medium shadow-lg hover:shadow-xl transform transition-all">
            <i class="fas fa-plus mr-2"></i>Add Payment Method
        </button>
    </div>

    <!-- Payment Methods Grid -->
    <div class="grid gap-6" id="paymentMethodsGrid">
        @forelse($paymentMethods as $method)
            <div class="glass-card rounded-xl p-6 floating-animation" 
                 data-method-id="{{ $method->id }}" 
                 data-aos="fade-up" 
                 data-aos-delay="{{ $loop->index * 100 }}">
                <div class="flex items-start justify-between">
                    <!-- Method Info -->
                    <div class="flex items-start space-x-4">
                        <!-- Method Icon -->
                        <div class="flex-shrink-0">
                            @if($method->method_type === 'paypal')
                                <div class="w-14 h-14 method-icon-bg rounded-xl flex items-center justify-center">
                                    <i class="fab fa-paypal text-blue-400 text-2xl"></i>
                                </div>
                            @elseif($method->method_type === 'bank_transfer')
                                <div class="w-14 h-14 method-icon-bg rounded-xl flex items-center justify-center">
                                    <i class="fas fa-university text-green-400 text-2xl"></i>
                                </div>
                            @else
                                <div class="w-14 h-14 method-icon-bg rounded-xl flex items-center justify-center">
                                    <i class="fas fa-mobile-alt text-purple-400 text-2xl"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Method Details -->
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-2">
                                <h3 class="font-semibold text-white text-lg">{{ $method->display_name }}</h3>
                                @if($method->is_default)
                                    <span class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-xs px-3 py-1 rounded-full font-medium pulse-glow">Default</span>
                                @endif
                                @if(!$method->is_active)
                                    <span class="bg-gray-500/30 text-white/80 text-xs px-3 py-1 rounded-full font-medium">Inactive</span>
                                @endif
                            </div>
                            
                            <p class="text-white/70 mb-3 font-medium">{{ $method->method_type_name }}</p>
                            
                            <div class="text-sm text-white/60 space-y-2">
                                @if($method->primary_identifier)
                                    <p><span class="font-medium text-white/80">Account:</span> {{ Str::mask($method->primary_identifier, '*', 3, -4) }}</p>
                                @endif
                                @if($method->currency)
                                    <p><span class="font-medium text-white/80">Currency:</span> {{ $method->currency }}</p>
                                @endif
                                <p><span class="font-medium text-white/80">Min Payout:</span> {{ $method->formatted_minimum_payout }}</p>
                            </div>

                            <!-- Verification Status -->
                            <div class="mt-4">
                                @if($method->verification_status === 'verified')
                                    <span class="inline-flex items-center text-green-400 text-sm font-medium">
                                        <i class="fas fa-check-circle mr-2"></i>Verified
                                    </span>
                                @elseif($method->verification_status === 'pending')
                                    <span class="inline-flex items-center text-yellow-400 text-sm font-medium">
                                        <i class="fas fa-clock mr-2"></i>Pending Verification
                                    </span>
                                @else
                                    <span class="inline-flex items-center text-red-400 text-sm font-medium">
                                        <i class="fas fa-times-circle mr-2"></i>Verification Failed
                                    </span>
                                @endif
                            </div>

                            <!-- Usage Stats -->
                            @if($method->total_payouts > 0)
                                <div class="mt-4 text-sm text-white/60">
                                    <p class="font-medium">{{ $method->total_payouts }} payout{{ $method->total_payouts > 1 ? 's' : '' }} • {{ $method->formatted_total_amount }} total</p>
                                    @if($method->last_used_at)
                                        <p>Last used {{ $method->last_used_at->diffForHumans() }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center space-x-3">
                        <!-- Toggle Default -->
                        <button onclick="toggleDefault({{ $method->id }})" 
                                class="w-10 h-10 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center transition-all" 
                                title="{{ $method->is_default ? 'Remove as default' : 'Set as default' }}">
                            <i class="fas fa-star {{ $method->is_default ? 'text-yellow-400' : 'text-white/60' }}"></i>
                        </button>

                        <!-- Toggle Active -->
                        <button onclick="toggleActive({{ $method->id }})" 
                                class="w-10 h-10 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center transition-all" 
                                title="{{ $method->is_active ? 'Deactivate' : 'Activate' }}">
                            <i class="fas fa-power-off {{ $method->is_active ? 'text-green-400' : 'text-white/60' }}"></i>
                        </button>

                        <!-- Edit -->
                        <button onclick="editPaymentMethod({{ $method->id }})" 
                                class="w-10 h-10 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center transition-all" 
                                title="Edit">
                            <i class="fas fa-edit text-white/60 hover:text-blue-400"></i>
                        </button>

                        <!-- Delete -->
                        <button onclick="deletePaymentMethod({{ $method->id }})" 
                                class="w-10 h-10 rounded-lg bg-white/10 hover:bg-red-500/20 flex items-center justify-center transition-all" 
                                title="Delete">
                            <i class="fas fa-trash text-white/60 hover:text-red-400"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-16" data-aos="fade-up">
                <div class="w-32 h-32 glass-card rounded-full flex items-center justify-center mx-auto mb-6 floating-animation">
                    <i class="fas fa-credit-card text-white/60 text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-3">No Payment Methods</h3>
                <p class="text-white/80 mb-8 text-lg">Add your first payment method to start receiving payouts</p>
                <button onclick="openCreateModal()" 
                        class="gradient-btn text-white px-8 py-3 rounded-xl font-medium shadow-lg hover:shadow-xl transform transition-all">
                    Add Payment Method
                </button>
            </div>
        @endforelse
    </div>
</div>

<!-- Create/Edit Modal -->
<div id="paymentMethodModal" class="fixed inset-0 modal-backdrop hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="glass-card rounded-2xl shadow-2xl max-w-md w-full max-h-screen overflow-y-auto" data-aos="zoom-in">
            <div class="p-8">
                <!-- Modal Header -->
                <div class="flex justify-between items-center mb-6">
                    <h2 id="modalTitle" class="text-2xl font-bold text-white">Add Payment Method</h2>
                    <button onclick="closeModal()" class="w-10 h-10 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center transition-all">
                        <i class="fas fa-times text-white/80 text-lg"></i>
                    </button>
                </div>

                <!-- Form -->
                <form id="paymentMethodForm">
                    <input type="hidden" id="methodId" name="method_id">
                    
                    <!-- Method Type -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-white/90 mb-3">Payment Method Type</label>
                        <select id="methodType" name="method_type" class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 backdrop-blur-sm" required>
                            <option value="">Select method type</option>
                            <option value="paypal">PayPal</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="mobile_money">Mobile Money</option>
                        </select>
                        <div class="text-red-400 text-sm mt-2 hidden" id="methodType_error"></div>
                    </div>

                    <!-- Method Name -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-white/90 mb-3">Method Name</label>
                        <input type="text" id="methodName" name="method_name" 
                               class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/60 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 backdrop-blur-sm" 
                               placeholder="e.g., My PayPal Account" required>
                        <div class="text-red-400 text-sm mt-2 hidden" id="methodName_error"></div>
                    </div>

                    <!-- Dynamic Fields Container -->
                    <div id="dynamicFields"></div>

                    <!-- Currency & Country -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-white/90 mb-3">Currency</label>
                            <select id="currency" name="currency" class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 backdrop-blur-sm" required>
                                <option value="USD">USD</option>
                                <option value="EUR">EUR</option>
                                <option value="GBP">GBP</option>
                                <option value="GHS">GHS</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-white/90 mb-3">Country</label>
                            <select id="countryCode" name="country_code" class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 backdrop-blur-sm" required>
                                <option value="USA">USA</option>
                                <option value="GBR">UK</option>
                                <option value="GHA">Ghana</option>
                                <option value="NGA">Nigeria</option>
                            </select>
                        </div>
                    </div>

                    <!-- Minimum Payout -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-white/90 mb-3">Minimum Payout Amount</label>
                        <input type="number" id="minimumPayout" name="minimum_payout" step="0.01" min="0" 
                               class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/60 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 backdrop-blur-sm" 
                               value="10.00">
                    </div>

                    <!-- Settings -->
                    <div class="mb-8 space-y-4">
                        <div class="flex items-center justify-between">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" id="isActive" name="is_active" class="sr-only" checked>
                                <div class="relative">
                                    <div class="w-11 h-6 bg-white/20 rounded-full shadow-inner"></div>
                                    <div class="absolute w-4 h-4 bg-white rounded-full shadow -left-1 -top-1 transition transform" id="activeToggle"></div>
                                </div>
                                <span class="ml-3 text-sm text-white/90">Active</span>
                            </label>
                        </div>
                        <div class="flex items-center justify-between">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" id="isDefault" name="is_default" class="sr-only">
                                <div class="relative">
                                    <div class="w-11 h-6 bg-white/20 rounded-full shadow-inner"></div>
                                    <div class="absolute w-4 h-4 bg-white rounded-full shadow -left-1 -top-1 transition transform" id="defaultToggle"></div>
                                </div>
                                <span class="ml-3 text-sm text-white/90">Set as default</span>
                            </label>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-4">
                        <button type="button" onclick="closeModal()" 
                                class="px-6 py-3 bg-white/10 hover:bg-white/20 text-white rounded-xl font-medium transition-all">
                            Cancel
                        </button>
                        <button type="submit" id="submitBtn"
                                class="gradient-btn px-6 py-3 text-white rounded-xl font-medium shadow-lg hover:shadow-xl transform transition-all">
                            <span id="submitText">Add Payment Method</span>
                            <i class="fas fa-spinner fa-spin ml-2 hidden" id="submitSpinner"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div id="toast" class="fixed top-4 right-4 glass-card rounded-xl p-4 transform translate-x-full transition-transform duration-300 z-50">
    <div class="flex items-center">
        <div id="toastIcon" class="flex-shrink-0 mr-3"></div>
        <div>
            <p id="toastMessage" class="text-sm font-medium text-white"></p>
        </div>
        <button onclick="hideToast()" class="ml-4 text-white/60 hover:text-white/80">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>

@endsection

@push('scripts')
<script>
let isEditing = false;
let currentMethodId = null;

// Initialize AOS
AOS.init({
    duration: 800,
    easing: 'ease-out-cubic',
    once: true
});

// Dynamic field templates with updated styling
const fieldTemplates = {
    paypal: `
        <div class="mb-6">
            <label class="block text-sm font-medium text-white/90 mb-3">PayPal Email</label>
            <input type="email" id="email" name="email" 
                   class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/60 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 backdrop-blur-sm" 
                   placeholder="your-email@example.com" required>
            <div class="text-red-400 text-sm mt-2 hidden" id="email_error"></div>
        </div>
        <div class="mb-6">
            <label class="block text-sm font-medium text-white/90 mb-3">Account Holder Name</label>
            <input type="text" id="accountName" name="account_name" 
                   class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/60 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 backdrop-blur-sm" 
                   placeholder="Full name on PayPal account">
        </div>
    `,
    bank_transfer: `
        <div class="mb-6">
            <label class="block text-sm font-medium text-white/90 mb-3">Account Holder Name</label>
            <input type="text" id="accountName" name="account_name" 
                   class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/60 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 backdrop-blur-sm" 
                   placeholder="Full name on bank account" required>
            <div class="text-red-400 text-sm mt-2 hidden" id="accountName_error"></div>
        </div>
        <div class="mb-6">
            <label class="block text-sm font-medium text-white/90 mb-3">Account Number</label>
            <input type="text" id="accountNumber" name="account_number" 
                   class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/60 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 backdrop-blur-sm" 
                   placeholder="Your bank account number" required>
            <div class="text-red-400 text-sm mt-2 hidden" id="accountNumber_error"></div>
        </div>
        <div class="mb-6">
            <label class="block text-sm font-medium text-white/90 mb-3">Bank Name</label>
            <input type="text" id="bankName" name="bank_name" 
                   class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/60 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 backdrop-blur-sm" 
                   placeholder="Name of your bank" required>
            <div class="text-red-400 text-sm mt-2 hidden" id="bankName_error"></div>
        </div>
        <div class="mb-6">
            <label class="block text-sm font-medium text-white/90 mb-3">Bank Country</label>
            <select id="bankCountry" name="bank_country" class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 backdrop-blur-sm">
                <option value="">Select bank country</option>
                <option value="USA">United States</option>
                <option value="GBR">United Kingdom</option>
                <option value="GHA">Ghana</option>
                <option value="NGA">Nigeria</option>
            </select>
        </div>
    `,
    mobile_money: `
        <div class="mb-6">
            <label class="block text-sm font-medium text-white/90 mb-3">Mobile Number</label>
            <input type="text" id="accountNumber" name="account_number" 
                   class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/60 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 backdrop-blur-sm" 
                   placeholder="Your mobile money number" required>
            <div class="text-red-400 text-sm mt-2 hidden" id="accountNumber_error"></div>
        </div>
        <div class="mb-6">
            <label class="block text-sm font-medium text-white/90 mb-3">Account Name</label>
            <input type="text" id="accountName" name="account_name" 
                   class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/60 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 backdrop-blur-sm" 
                   placeholder="Name on mobile money account">
        </div>
        <div class="mb-6">
            <label class="block text-sm font-medium text-white/90 mb-3">Email (Optional)</label>
            <input type="email" id="email" name="email" 
                   class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/60 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 backdrop-blur-sm" 
                   placeholder="your-email@example.com">
        </div>
    `
};

// Custom toggle switches
function initializeToggleSwitches() {
    const activeToggle = document.getElementById('activeToggle');
    const defaultToggle = document.getElementById('defaultToggle');
    const activeCheckbox = document.getElementById('isActive');
    const defaultCheckbox = document.getElementById('isDefault');

    function updateToggle(toggle, checkbox) {
        if (checkbox.checked) {
            toggle.style.transform = 'translateX(20px)';
            toggle.style.backgroundColor = '#3b82f6';
        } else {
            toggle.style.transform = 'translateX(0px)';
            toggle.style.backgroundColor = '#ffffff';
        }
    }

    activeCheckbox.addEventListener('change', () => updateToggle(activeToggle, activeCheckbox));
    defaultCheckbox.addEventListener('change', () => updateToggle(defaultToggle, defaultCheckbox));

    // Initialize states
    updateToggle(activeToggle, activeCheckbox);
    updateToggle(defaultToggle, defaultCheckbox);
}

// Modal functions
function openCreateModal() {
    isEditing = false;
    currentMethodId = null;
    document.getElementById('modalTitle').textContent = 'Add Payment Method';
    document.getElementById('submitText').textContent = 'Add Payment Method';
    document.getElementById('paymentMethodForm').reset();
    document.getElementById('methodId').value = '';
    document.getElementById('dynamicFields').innerHTML = '';
    document.getElementById('isActive').checked = true;
    document.getElementById('isDefault').checked = false;
    clearErrors();
    document.getElementById('paymentMethodModal').classList.remove('hidden');
    setTimeout(initializeToggleSwitches, 100);
}

function closeModal() {
    document.getElementById('paymentMethodModal').classList.add('hidden');
    clearErrors();
}

function clearErrors() {
    document.querySelectorAll('[id$="_error"]').forEach(el => {
        el.classList.add('hidden');
        el.textContent = '';
    });
    document.querySelectorAll('.border-red-500').forEach(el => {
        el.classList.remove('border-red-500');
        el.classList.add('border-white/20');
    });
}

// Method type change handler
document.getElementById('methodType').addEventListener('change', function() {
    const methodType = this.value;
    const dynamicFields = document.getElementById('dynamicFields');
    
    if (methodType && fieldTemplates[methodType]) {
        dynamicFields.innerHTML = fieldTemplates[methodType];
    } else {
        dynamicFields.innerHTML = '';

        }
});

// Form submission
document.getElementById('paymentMethodForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const submitSpinner = document.getElementById('submitSpinner');
    
    // Show loading state
    submitBtn.disabled = true;
    submitText.textContent = isEditing ? 'Updating...' : 'Adding...';
    submitSpinner.classList.remove('hidden');
    
    clearErrors();
    
    const formData = new FormData(this);
    const url = isEditing ? `/payment-methods/${currentMethodId}` : '/payment-methods';
    const method = isEditing ? 'PUT' : 'POST';
    
    // Convert FormData to JSON for PUT requests
    const data = {};
    formData.forEach((value, key) => {
        if (key === 'is_active' || key === 'is_default') {
            data[key] = document.getElementById(key === 'is_active' ? 'isActive' : 'isDefault').checked;
        } else {
            data[key] = value;
        }
    });
    
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeModal();
            showToast('success', data.message || (isEditing ? 'Payment method updated successfully!' : 'Payment method added successfully!'));
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            throw new Error(data.message || 'Something went wrong');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (error.response && error.response.status === 422) {
            // Validation errors
            error.response.json().then(data => {
                if (data.errors) {
                    Object.keys(data.errors).forEach(field => {
                        const errorElement = document.getElementById(field + '_error');
                        const inputElement = document.getElementById(field) || document.querySelector(`[name="${field}"]`);
                        
                        if (errorElement) {
                            errorElement.textContent = data.errors[field][0];
                            errorElement.classList.remove('hidden');
                        }
                        
                        if (inputElement) {
                            inputElement.classList.add('border-red-500');
                            inputElement.classList.remove('border-white/20');
                        }
                    });
                }
            });
        } else {
            showToast('error', error.message || 'An error occurred. Please try again.');
        }
    })
    .finally(() => {
        // Reset loading state
        submitBtn.disabled = false;
        submitText.textContent = isEditing ? 'Update Payment Method' : 'Add Payment Method';
        submitSpinner.classList.add('hidden');
    });
});


// Helper function to get authentication token
function getAuthToken() {
    // Adjust this based on how you store your auth token
    return localStorage.getItem('auth_token') || 
           sessionStorage.getItem('auth_token') || 
           document.querySelector('meta[name="api-token"]')?.getAttribute('content') || 
           '';
}

// Edit payment method with improved error handling
function editPaymentMethod(id) {
    // Validate ID parameter
    if (!id) {
        showToast('error', 'Invalid payment method ID');
        return;
    }

    isEditing = true;
    currentMethodId = id;
    
    // Show loading state
    const modal = document.getElementById('paymentMethodModal');
    if (modal) {
        modal.classList.remove('hidden');
        // You might want to show a loading spinner here
    }
    
    fetch(`/payment-methods/${id}/edit`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            // Add authentication headers
            'Authorization': `Bearer ${getAuthToken()}`, // If using Bearer tokens
            // Add CSRF token if needed
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
            // Add any other required headers
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'include' // Include cookies for session-based auth
    })
    .then(response => {
        console.log('Response status:', response.status);
        
        // Check if response is ok
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        // Check content type
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            throw new Error('Response is not JSON');
        }
        
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        
        if (data.success && data.data) {
            const method = data.data;
            
            // Update modal title
            const modalTitle = document.getElementById('modalTitle');
            const submitText = document.getElementById('submitText');
            
            if (modalTitle) modalTitle.textContent = 'Edit Payment Method';
            if (submitText) submitText.textContent = 'Update Payment Method';
            
            // Populate form fields with null checks
            const fields = [
                { id: 'methodId', value: method.id },
                { id: 'methodType', value: method.method_type },
                { id: 'methodName', value: method.display_name },
                { id: 'currency', value: method.currency || 'USD' },
                { id: 'countryCode', value: method.country_code || 'USA' },
                { id: 'minimumPayout', value: method.minimum_payout || '10.00' }
            ];
            
            fields.forEach(field => {
                const element = document.getElementById(field.id);
                if (element) {
                    element.value = field.value || '';
                }
            });
            
            // Handle checkboxes
            const isActiveEl = document.getElementById('isActive');
            const isDefaultEl = document.getElementById('isDefault');
            
            if (isActiveEl) isActiveEl.checked = !!method.is_active;
            if (isDefaultEl) isDefaultEl.checked = !!method.is_default;
            
            // Trigger method type change to load dynamic fields
            const methodTypeEl = document.getElementById('methodType');
            if (methodTypeEl) {
                methodTypeEl.dispatchEvent(new Event('change'));
            }
            
            // Wait for dynamic fields to load, then populate them
            setTimeout(() => {
                populateDynamicFields(method);
                
                // Initialize toggle switches
                if (typeof initializeToggleSwitches === 'function') {
                    initializeToggleSwitches();
                }
            }, 200); // Increased timeout
            
        } else {
            throw new Error(data.message || 'Invalid response format');
        }
    })
    .catch(error => {
        console.error('Error loading payment method:', error);
        
        // Hide modal on error
        const modal = document.getElementById('paymentMethodModal');
        if (modal) {
            modal.classList.add('hidden');
        }
        
        // Show specific error message
        let errorMessage = 'Failed to load payment method details';
        
        if (error.message.includes('404')) {
            errorMessage = 'Payment method not found';
        } else if (error.message.includes('403')) {
            errorMessage = 'You do not have permission to edit this payment method';
        } else if (error.message.includes('401')) {
            errorMessage = 'Please log in to continue';
            // Optionally redirect to login
            // window.location.href = '/login';
        } else if (error.message.includes('500')) {
            errorMessage = 'Server error occurred';
        } else if (error.message.includes('NetworkError') || error.message.includes('Failed to fetch')) {
            errorMessage = 'Network connection error';
        }
        
        showToast('error', errorMessage);
        
        // Reset editing state
        isEditing = false;
        currentMethodId = null;
    });
}

// Helper function to populate dynamic fields
function populateDynamicFields(method) {
    const methodData = method.method_data || {};
    
    switch (method.method_type) {
        case 'paypal':
            setFieldValue('email', methodData.email || method.primary_identifier);
            setFieldValue('accountName', methodData.account_name);
            break;
            
        case 'bank_transfer':
            setFieldValue('accountName', methodData.account_name);
            setFieldValue('accountNumber', methodData.account_number || method.primary_identifier);
            setFieldValue('bankName', methodData.bank_name);
            setFieldValue('bankCountry', methodData.bank_country);
            break;
            
        case 'mobile_money':
            setFieldValue('accountNumber', methodData.account_number || method.primary_identifier);
            setFieldValue('accountName', methodData.account_name);
            setFieldValue('email', methodData.email);
            break;
            
        default:
            console.warn('Unknown method type:', method.method_type);
    }
}

// Helper function to safely set field values
function setFieldValue(fieldId, value) {
    const element = document.getElementById(fieldId);
    if (element && value !== undefined && value !== null) {
        element.value = value;
    }
}

// Helper function to get authentication token
function getAuthToken() {
    return localStorage.getItem('auth_token') || 
           sessionStorage.getItem('auth_token') || 
           document.querySelector('meta[name="api-token"]')?.getAttribute('content') || 
           '';
}

// Delete payment method with proper permission handling
function deletePaymentMethod(id, methodName = 'this payment method') {
    // Validate ID parameter
    if (!id) {
        showToast('error', 'Invalid payment method ID');
        return;
    }

    // Confirm deletion
    if (!confirm(`Are you sure you want to delete "${methodName}"? This action cannot be undone.`)) {
        return;
    }

    // Show loading state
    const deleteButton = document.querySelector(`[data-delete-id="${id}"]`);
    if (deleteButton) {
        deleteButton.disabled = true;
        deleteButton.textContent = 'Deleting...';
    }

    fetch(`/payment-methods/${id}`, {
        method: 'DELETE',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            // Add authentication headers
            'Authorization': `Bearer ${getAuthToken()}`,
            // Add CSRF token
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'include'
    })
    .then(response => {
        console.log('Delete response status:', response.status);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            return response.json();
        } else {
            // Some APIs return empty response on successful delete
            return { success: true };
        }
    })
    .then(data => {
        console.log('Delete response data:', data);
        
        if (data.success) {
            showToast('success', 'Payment method deleted successfully');
            
            // Remove the payment method from the UI
            removePaymentMethodFromUI(id);
            
            // Update any counters or lists
            updatePaymentMethodCount();
            
            // Close any open modals
            closePaymentMethodModal();
            
        } else {
            throw new Error(data.message || 'Failed to delete payment method');
        }
    })
    .catch(error => {
        console.error('Error deleting payment method:', error);
        
        // Show specific error message based on the error
        let errorMessage = 'Failed to delete payment method';
        
        if (error.message.includes('403')) {
            errorMessage = 'You do not have permission to delete this payment method';
        } else if (error.message.includes('401')) {
            errorMessage = 'Please log in to continue';
            // Optionally redirect to login
            // window.location.href = '/login';
        } else if (error.message.includes('404')) {
            errorMessage = 'Payment method not found';
        } else if (error.message.includes('409')) {
            errorMessage = 'Cannot delete payment method - it may be in use';
        } else if (error.message.includes('500')) {
            errorMessage = 'Server error occurred';
        } else if (error.message.includes('NetworkError') || error.message.includes('Failed to fetch')) {
            errorMessage = 'Network connection error';
        }
        
        showToast('error', errorMessage);
    })
    .finally(() => {
        // Reset button state
        if (deleteButton) {
            deleteButton.disabled = false;
            deleteButton.textContent = 'Delete';
        }
    });
}

// Helper function to remove payment method from UI
function removePaymentMethodFromUI(id) {
    // Remove from table/list
    const row = document.querySelector(`[data-method-id="${id}"]`);
    if (row) {
        row.remove();
    }
    
    // Remove from any dropdowns or selects
    const options = document.querySelectorAll(`option[value="${id}"]`);
    options.forEach(option => option.remove());
    
    // Update empty state if no methods left
    const methodsContainer = document.querySelector('#payment-methods-list');
    if (methodsContainer && methodsContainer.children.length === 0) {
        showEmptyState();
    }
}

// Helper function to update payment method count
function updatePaymentMethodCount() {
    const countElement = document.querySelector('#payment-methods-count');
    if (countElement) {
        const currentCount = parseInt(countElement.textContent) || 0;
        countElement.textContent = Math.max(0, currentCount - 1);
    }
}

// Helper function to show empty state
function showEmptyState() {
    const container = document.querySelector('#payment-methods-list');
    if (container) {
        container.innerHTML = `
            <div class="empty-state text-center py-8">
                <p class="text-gray-500">No payment methods found</p>
                <button onclick="showAddPaymentMethodModal()" class="btn btn-primary mt-4">
                    Add Your First Payment Method
                </button>
            </div>
        `;
    }
}

// Helper function to close modal
function closePaymentMethodModal() {
    const modal = document.getElementById('paymentMethodModal');
    if (modal) {
        modal.classList.add('hidden');
    }
}

// Enhanced function to check if user can delete a payment method
function canDeletePaymentMethod(methodId) {
    // Check if it's the user's default payment method
    const method = getUserPaymentMethod(methodId);
    
    if (!method) {
        return { canDelete: false, reason: 'Payment method not found' };
    }
    
    if (method.is_default) {
        return { 
            canDelete: false, 
            reason: 'Cannot delete default payment method. Set another method as default first.' 
        };
    }
    
    if (method.has_pending_transactions) {
        return { 
            canDelete: false, 
            reason: 'Cannot delete payment method with pending transactions' 
        };
    }
    
    return { canDelete: true };
}

// Enhanced delete function with pre-validation
function deletePaymentMethodWithValidation(id, methodName) {
    const validation = canDeletePaymentMethod(id);
    
    if (!validation.canDelete) {
        showToast('error', validation.reason);
        return;
    }
    
    deletePaymentMethod(id, methodName);
}

// Helper function to get user's payment method by ID
function getUserPaymentMethod(methodId) {
    // This should be implemented based on your data structure
    // Example implementation:
    const methods = window.userPaymentMethods || [];
    return methods.find(method => method.id == methodId);
}

// Bulk delete function for multiple payment methods
function deleteMultiplePaymentMethods(ids) {
    if (!ids || ids.length === 0) {
        showToast('error', 'No payment methods selected');
        return;
    }
    
    if (!confirm(`Are you sure you want to delete ${ids.length} payment method(s)? This action cannot be undone.`)) {
        return;
    }
    
    const promises = ids.map(id => 
        fetch(`/payment-methods/${id}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${getAuthToken()}`,
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'include'
        })
    );
    
    Promise.allSettled(promises)
        .then(results => {
            const successful = results.filter(result => result.status === 'fulfilled').length;
            const failed = results.length - successful;
            
            if (successful > 0) {
                showToast('success', `${successful} payment method(s) deleted successfully`);
                // Refresh the payment methods list
                location.reload();
            }
            
            if (failed > 0) {
                showToast('error', `Failed to delete ${failed} payment method(s)`);
            }
        });
}



// Toggle default status
function toggleDefault(id) {
    fetch(`/payment-methods/${id}/toggle-default`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showToast('success', data.message);
            
            // Update UI immediately - remove default badge from all methods first
            document.querySelectorAll('[data-method-id]').forEach(card => {
                const defaultBadge = card.querySelector('span:contains("Default")');
                const starIcon = card.querySelector('button[title*="default"] i, button[title*="Default"] i');
                
                if (defaultBadge) {
                    defaultBadge.remove();
                }
                if (starIcon) {
                    starIcon.classList.remove('text-yellow-400');
                    starIcon.classList.add('text-white/60');
                    starIcon.parentElement.setAttribute('title', 'Set as default');
                }
            });
            
            // Add default badge to the selected method
            const methodCard = document.querySelector(`[data-method-id="${id}"]`);
            const badgeContainer = methodCard?.querySelector('.flex.items-center.space-x-3');
            const starButton = methodCard?.querySelector('button[title*="default"], button[title*="Default"]');
            const starIcon = starButton?.querySelector('i');
            
            if (badgeContainer && !badgeContainer.querySelector('span:contains("Default")')) {
                const defaultBadge = document.createElement('span');
                defaultBadge.className = 'bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-xs px-3 py-1 rounded-full font-medium pulse-glow';
                defaultBadge.textContent = 'Default';
                badgeContainer.appendChild(defaultBadge);
            }
            
            if (starIcon) {
                starIcon.classList.remove('text-white/60');
                starIcon.classList.add('text-yellow-400');
                starButton.setAttribute('title', 'Remove as default');
            }
        } else {
            showToast('error', data.message || 'Failed to update default status');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (error.message.includes('404')) {
            showToast('error', 'Payment method not found');
        } else if (error.message.includes('403')) {
            showToast('error', 'You do not have permission to perform this action');
        } else if (error.message.includes('500')) {
            showToast('error', 'Server error occurred. Please try again later');
        } else {
            showToast('error', 'An error occurred while updating default status');
        }
    });
}

// Toggle active status
function toggleActive(id) {
    fetch(`/payment-methods/${id}/toggle-active`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showToast('success', data.message);
            
            // Update the UI immediately instead of reloading
            const methodCard = document.querySelector(`[data-method-id="${id}"]`);
            const activeButton = methodCard?.querySelector('button[title*="Activate"], button[title*="Deactivate"]');
            const activeIcon = activeButton?.querySelector('i');
            const inactiveSpan = methodCard?.querySelector('span:contains("Inactive")');
            
            if (activeIcon) {
                if (activeIcon.classList.contains('text-green-400')) {
                    // Currently active, make inactive
                    activeIcon.classList.remove('text-green-400');
                    activeIcon.classList.add('text-white/60');
                    activeButton.setAttribute('title', 'Activate');
                    
                    // Add inactive badge if not exists
                    if (!inactiveSpan && methodCard) {
                        const badgeContainer = methodCard.querySelector('.flex.items-center.space-x-3');
                        if (badgeContainer) {
                            const inactiveBadge = document.createElement('span');
                            inactiveBadge.className = 'bg-gray-500/30 text-white/80 text-xs px-3 py-1 rounded-full font-medium';
                            inactiveBadge.textContent = 'Inactive';
                            badgeContainer.appendChild(inactiveBadge);
                        }
                    }
                } else {
                    // Currently inactive, make active
                    activeIcon.classList.remove('text-white/60');
                    activeIcon.classList.add('text-green-400');
                    activeButton.setAttribute('title', 'Deactivate');
                    
                    // Remove inactive badge
                    const inactiveBadge = methodCard?.querySelector('span:contains("Inactive")');
                    if (inactiveBadge) {
                        inactiveBadge.remove();
                    }
                }
            }
        } else {
            showToast('error', data.message || 'Failed to update active status');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (error.message.includes('404')) {
            showToast('error', 'Payment method not found');
        } else if (error.message.includes('403')) {
            showToast('error', 'You do not have permission to perform this action');
        } else if (error.message.includes('500')) {
            showToast('error', 'Server error occurred. Please try again later');
        } else {
            showToast('error', 'An error occurred while updating active status');
        }
    });
}

// Toast notification functions
function showToast(type, message) {
    const toast = document.getElementById('toast');
    const toastIcon = document.getElementById('toastIcon');
    const toastMessage = document.getElementById('toastMessage');
    
    // Set icon and colors based on type
    let iconHtml = '';
    let bgClass = '';
    
    switch (type) {
        case 'success':
            iconHtml = '<i class="fas fa-check-circle text-green-400 text-xl"></i>';
            bgClass = 'bg-green-500/20 border-green-500/30';
            break;
        case 'error':
            iconHtml = '<i class="fas fa-times-circle text-red-400 text-xl"></i>';
            bgClass = 'bg-red-500/20 border-red-500/30';
            break;
        case 'warning':
            iconHtml = '<i class="fas fa-exclamation-triangle text-yellow-400 text-xl"></i>';
            bgClass = 'bg-yellow-500/20 border-yellow-500/30';
            break;
        default:
            iconHtml = '<i class="fas fa-info-circle text-blue-400 text-xl"></i>';
            bgClass = 'bg-blue-500/20 border-blue-500/30';
    }
    
    toastIcon.innerHTML = iconHtml;
    toastMessage.textContent = message;
    toast.className = `fixed top-4 right-4 glass-card rounded-xl p-4 transform transition-transform duration-300 z-50 ${bgClass}`;
    
    // Show toast
    toast.style.transform = 'translateX(0)';
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        hideToast();
    }, 5000);
}

function hideToast() {
    const toast = document.getElementById('toast');
    toast.style.transform = 'translateX(100%)';
}

// Close modal on outside click
document.getElementById('paymentMethodModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

// Initialize toggle switches on page load
document.addEventListener('DOMContentLoaded', function() {
    // Add any initialization code here if needed
    console.log('Payment Methods page loaded');
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Escape key to close modal
    if (e.key === 'Escape') {
        const modal = document.getElementById('paymentMethodModal');
        if (!modal.classList.contains('hidden')) {
            closeModal();
        }
        hideToast();
    }
    
    // Ctrl/Cmd + N to add new payment method
    if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
        e.preventDefault();
        openCreateModal();
    }
});

// Add some utility functions for form validation
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function validatePhoneNumber(phone) {
    const re = /^[\+]?[1-9][\d]{0,15}$/;
    return re.test(phone.replace(/\s/g, ''));
}

// Auto-format phone numbers for mobile money
document.addEventListener('input', function(e) {
    if (e.target.id === 'accountNumber' && document.getElementById('methodType').value === 'mobile_money') {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 0 && !value.startsWith('+')) {
            // Add country code placeholder
            if (value.length <= 10) {
                value = '+233' + value; // Ghana default
            }
        }
        e.target.value = value;
    }
});

// Add real-time form validation
document.addEventListener('blur', function(e) {
    if (e.target.type === 'email') {
        const errorElement = document.getElementById(e.target.id + '_error');
        if (e.target.value && !validateEmail(e.target.value)) {
            if (errorElement) {
                errorElement.textContent = 'Please enter a valid email address';
                errorElement.classList.remove('hidden');
                e.target.classList.add('border-red-500');
            }
        } else {
            if (errorElement) {
                errorElement.classList.add('hidden');
                e.target.classList.remove('border-red-500');
                e.target.classList.add('border-white/20');
            }
        }
    }
}, true);
</script>

@endpush