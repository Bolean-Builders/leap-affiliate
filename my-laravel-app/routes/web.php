<?php

use App\Http\Controllers\Vendor\EarningsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\AffiliateDashboardController;
use App\Http\Controllers\VendorDashboardController;
use App\Http\Controllers\Vendor\ProductController;
use App\Http\Controllers\PaymentMethodController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
| Routes accessible to everyone (no authentication required)
*/

// Root/Landing Page
Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        switch ($user->role) {
            case 'affiliate':
                return redirect()->route('affiliate.affdash');
            case 'vendor':
                return redirect()->route('vendor.vendash');
            default:
                return redirect()->route('home');
        }
    }
    return view('welcome');
})->name('root');

/*
|--------------------------------------------------------------------------
| Guest Routes (Authentication)
|--------------------------------------------------------------------------
| Routes only accessible to unauthenticated users
*/

Route::middleware('guest')->group(function () {
    
    // Login Routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    Route::post('/ajax/login', [LoginController::class, 'ajaxLogin'])->name('login.ajax');

    // Registration Routes
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

    // Password Reset Routes
    Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
| Routes requiring user authentication
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | General Auth Routes
    |--------------------------------------------------------------------------
    */
    
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // AJAX Auth Check
    Route::get('/auth/check', [LoginController::class, 'checkAuth'])->name('auth.check');

    /*
    |--------------------------------------------------------------------------
    | Role-Based Dashboard Redirects
    |--------------------------------------------------------------------------
    */
    
    Route::get('/home', function () {
        $user = auth()->user();
        switch ($user->role) {
            case 'affiliate':
                return redirect()->route('affiliate.dashboard');
            case 'vendor':
                return redirect()->route('vendor.dashboard');
            default:
                return view('home');
        }
    })->name('home');

    Route::get('/dashboard', function () {
        $user = auth()->user();
        switch ($user->role) {
            case 'affiliate':
                return redirect()->route('affiliate.dashboard');
            case 'vendor':
                return redirect()->route('vendor.dashboard');
            default:
                return view('dashboard');
        }
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Affiliate Routes
    |--------------------------------------------------------------------------
    | Routes specific to affiliate users
    */
    
    Route::prefix('affiliate')
        ->name('affiliate.')
        ->middleware('role:affiliate')
        ->group(function () {
            // Dashboard
            Route::get('/dashboard', [AffiliateDashboardController::class, 'index'])->name('dashboard');
            Route::get('/affdash', [AffiliateDashboardController::class, 'index'])->name('affdash');
            
            // Affiliate Features
            Route::get('/earnings', [AffiliateDashboardController::class, 'getEarningsData'])->name('earnings');
            Route::get('/profile', [AffiliateDashboardController::class, 'profile'])->name('profile');
            Route::get('/reports', [AffiliateDashboardController::class, 'reports'])->name('reports');
        });

    /*
    |--------------------------------------------------------------------------
    | Vendor Routes
    |--------------------------------------------------------------------------
    | Routes specific to vendor users
    */
    
    Route::prefix('vendor')
        ->name('vendor.')
        ->middleware('role:vendor')
        ->group(function () {
Route::get('/earnings', [EarningsController::class, 'index'])->name('earnings');

            /*
            |--------------------------------------------------------------------------
            | Vendor Dashboard Routes
            |--------------------------------------------------------------------------
            */
            
            
            Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');
            Route::get('/vendash', [VendorDashboardController::class, 'index'])->name('vendash');
            Route::get('/orders', [VendorDashboardController::class, 'orders'])->name('orders');
            Route::get('/analytics', [VendorDashboardController::class, 'analytics'])->name('analytics');
            Route::get('/profile', [VendorDashboardController::class, 'profile'])->name('profile');
            Route::get('/settings', [VendorDashboardController::class, 'settings'])->name('settings');

            /*
            |--------------------------------------------------------------------------
            | Product Management Routes
            |--------------------------------------------------------------------------
            */
            
            Route::prefix('products')
                ->name('products.')
                ->group(function () {
                    
                    // Product Display Routes
                    Route::get('/', [ProductController::class, 'index'])->name('index');
                    Route::get('/create', [ProductController::class, 'create'])->name('create');
                    Route::get('/{product}/edit', [ProductController::class, 'edit'])
                        ->name('edit')
                        ->where('product', '[0-9]+');
                    Route::get('/{product}/analytics', [ProductController::class, 'analytics'])
                        ->name('analytics')
                        ->where('product', '[0-9]+');
                    Route::get('/{product}', [ProductController::class, 'show'])
                        ->name('show')
                        ->where('product', '[0-9]+');

                    // Product CRUD Operations
                    Route::post('/', [ProductController::class, 'store'])->name('store');
                    Route::put('/{product}', [ProductController::class, 'update'])
                        ->name('update')
                        ->where('product', '[0-9]+');
                    Route::delete('/{product}', [ProductController::class, 'destroy'])
                        ->name('destroy')
                        ->where('product', '[0-9]+');

                    // Product API/AJAX Routes
                    Route::get('/get-products', [ProductController::class, 'getProducts'])->name('get');

                    // Bulk Actions & Status Management
                    Route::post('/bulk-update-status', [ProductController::class, 'bulkUpdateStatus'])->name('bulk-update-status');
                    Route::patch('/{product}/toggle-status', [ProductController::class, 'toggleStatus'])
                        ->name('toggle')
                        ->where('product', '[0-9]+');

                    // Additional Product Actions
                    Route::post('/{product}/duplicate', [ProductController::class, 'duplicate'])
                        ->name('duplicate')
                        ->where('product', '[0-9]+');
                    
                    // Import/Export
                    Route::get('/export', [ProductController::class, 'export'])->name('export');
                    Route::post('/import', [ProductController::class, 'import'])->name('import');
                });

            /*
            |--------------------------------------------------------------------------
            | Vendor Payment Methods Routes
            |--------------------------------------------------------------------------
            */
            
          /*
            |--------------------------------------------------------------------------
            | Vendor Payment Methods Routes
            |--------------------------------------------------------------------------
            */
            
            Route::prefix('payment-methods')
                ->name('payment-methods.')
                ->group(function () {
                    
                    // Main Routes - using 'blasd' instead of 'index'
                    Route::get('/', [PaymentMethodController::class, 'index'])->name('blade');
                    Route::get('/create', [PaymentMethodController::class, 'create'])->name('create');
                    Route::post('/', [PaymentMethodController::class, 'store'])->name('store');
                    Route::get('/{paymentMethod}', [PaymentMethodController::class, 'show'])->name('show');
                    Route::get('/{paymentMethod}/edit', [PaymentMethodController::class, 'edit'])->name('edit');
                    Route::put('/{paymentMethod}', [PaymentMethodController::class, 'update'])->name('update');
                    Route::delete('/{paymentMethod}', [PaymentMethodController::class, 'destroy'])->name('destroy');

                    // Toggle Actions
                    Route::post('/{paymentMethod}/toggle-default', [PaymentMethodController::class, 'toggleDefault'])->name('toggle-default');
                    Route::post('/{paymentMethod}/toggle-active', [PaymentMethodController::class, 'toggleActive'])->name('toggle-active');
                    
                    // Bulk Actions
                    Route::post('/bulk-update-status', [PaymentMethodController::class, 'bulkUpdateStatus'])->name('bulk-update-status');
                    Route::post('/bulk-delete', [PaymentMethodController::class, 'bulkDelete'])->name('bulk-delete');
                });
        });

    /*
    |--------------------------------------------------------------------------
    | Payment Methods Routes
    |--------------------------------------------------------------------------
    | Routes for payment method management (available to authenticated users)
    */

    Route::prefix('payment-methods')
        ->name('payment-methods.')
        ->group(function () {
            
            // Main Routes
            Route::get('/', [PaymentMethodController::class, 'index'])->name('index');
            Route::post('/', [PaymentMethodController::class, 'store'])->name('store');
            Route::get('/{paymentMethod}/edit', [PaymentMethodController::class, 'edit'])->name('edit');
            Route::put('/{paymentMethod}', [PaymentMethodController::class, 'update'])->name('update');
            Route::delete('/{paymentMethod}', [PaymentMethodController::class, 'destroy'])->name('destroy');

            // Toggle Actions
            Route::post('/{paymentMethod}/toggle-default', [PaymentMethodController::class, 'toggleDefault'])->name('toggle-default');
            Route::post('/{paymentMethod}/toggle-active', [PaymentMethodController::class, 'toggleActive'])->name('toggle-active');
        });

    /*
    |--------------------------------------------------------------------------
    | API Routes (Authenticated)
    |--------------------------------------------------------------------------
    | API endpoints for authenticated users
    */
    
    Route::prefix('api')
        ->name('api.')
        ->group(function () {
            
            // Payment Methods API
            Route::prefix('payment-methods')
                ->name('payment-methods.')
                ->group(function () {
                    Route::get('/', [PaymentMethodController::class, 'getPaymentMethods'])->name('index');
                    Route::get('/default/{methodType?}', [PaymentMethodController::class, 'getDefault'])->name('default');
                    Route::get('/types', [PaymentMethodController::class, 'getMethodTypes'])->name('types');
                });
        });
});