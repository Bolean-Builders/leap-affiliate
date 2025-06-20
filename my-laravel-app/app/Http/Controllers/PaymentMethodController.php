<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PaymentMethodController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the main payment methods page
     */
    public function index(): View
    {
        $paymentMethods = Auth::user()->paymentMethods()
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('vendor.payment-methods', compact('paymentMethods'));
    }

    /**
     * Store a new payment method
     */
   public function store(Request $request): JsonResponse
{
    $validator = $this->validatePaymentMethod($request);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        $userId = Auth::id();
        $methodType = $request->input('method_type');

        // Check even soft-deleted payment methods
        $existingMethod = PaymentMethod::withTrashed()
            ->where('user_id', $userId)
            ->where('method_type', $methodType)
            ->first();

        if ($existingMethod) {
            if ($existingMethod->trashed()) {
                // Restore and update the soft-deleted method
                $existingMethod->restore();
                $existingMethod->update($validator->validated());

                return response()->json([
                    'success' => true,
                    'message' => 'Previously deleted payment method restored and updated.',
                    'payment_method' => $existingMethod->load('user'),
                    'redirect' => route('payment-methods.index')
                ]);
            }

            $methodTypeName = ucwords(str_replace('_', ' ', $methodType));
            return response()->json([
                'success' => false,
                'error' => 'DUPLICATE_PAYMENT_METHOD',
                'message' => "You already have a {$methodTypeName} payment method created. Please update the existing one or delete it first to create a new one.",
                'existing_method' => [
                    'id' => $existingMethod->id,
                    'method_type' => $existingMethod->method_type,
                    'method_name' => $existingMethod->method_name,
                    'account_number' => $this->maskAccountNumber($existingMethod->account_number ?? ''),
                    'created_at' => $existingMethod->created_at?->format('Y-m-d H:i:s')
                ]
            ], 409);
        }

        // No conflicts, create new
        $paymentMethod = Auth::user()->paymentMethods()->create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Payment method created successfully',
            'payment_method' => $paymentMethod->load('user'),
            'redirect' => route('payment-methods.index')
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to create payment method: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Get payment method for editing
     */
    public function edit(PaymentMethod $paymentMethod): JsonResponse
{
    $this->authorize('update', $paymentMethod);

    return response()->json([
        'success' => true,
        'data' => $paymentMethod
    ]);
}

    /**
     * Update payment method
     */
    public function update(Request $request, PaymentMethod $paymentMethod): JsonResponse
    {
        $this->authorize('update', $paymentMethod);

        $validator = $this->validatePaymentMethod($request, $paymentMethod->id);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $userId = Auth::id();
            $methodType = $request->input('method_type');
            
            // Check if another payment method of same type exists (excluding current one)
            $existingMethod = PaymentMethod::where('user_id', $userId)
                                          ->where('method_type', $methodType)
                                          ->where('id', '!=', $paymentMethod->id)
                                          ->first();
            
            if ($existingMethod) {
                $methodTypeName = ucwords(str_replace('_', ' ', $methodType));
                
                return response()->json([
                    'success' => false,
                    'error' => 'DUPLICATE_PAYMENT_METHOD',
                    'message' => "Duplicate paymenty bmethod.",
                    'existing_method' => [
                        'id' => $existingMethod->id,
                        'method_type' => $existingMethod->method_type,
                        'method_name' => $existingMethod->method_name,
                        'account_number' => $this->maskAccountNumber($existingMethod->account_number),
                        'created_at' => $existingMethod->created_at->format('Y-m-d H:i:s')
                    ]
                ], 409);
            }

            $paymentMethod->update($validator->validated());

            return response()->json([
                'success' => true,
                'message' => 'Payment method updated successfully',
                'payment_method' => $paymentMethod->fresh(),
                'redirect' => route('payment-methods.index')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update payment method: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle payment method as default
     */
    public function toggleDefault(PaymentMethod $paymentMethod): JsonResponse
    {
        $this->authorize('update', $paymentMethod);

        try {
            if ($paymentMethod->is_default) {
                $paymentMethod->update(['is_default' => false]);
                $message = 'Payment method removed as default';
            } else {
                $paymentMethod->markAsDefault();
                $message = 'Payment method set as default';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'is_default' => $paymentMethod->fresh()->is_default
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update default status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle payment method active status
     */
    public function toggleActive(PaymentMethod $paymentMethod): JsonResponse
    {
        $this->authorize('update', $paymentMethod);

        try {
            if ($paymentMethod->is_active) {
                $paymentMethod->deactivate();
                $message = 'Payment method deactivated';
            } else {
                $paymentMethod->activate();
                $message = 'Payment method activated';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'is_active' => $paymentMethod->fresh()->is_active
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update active status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Soft delete payment method
     */
    public function destroy(PaymentMethod $paymentMethod): JsonResponse
    {
        $this->authorize('delete', $paymentMethod);

        try {
            // If this was the default payment method, we might want to set another as default
            $wasDefault = $paymentMethod->is_default;
            
            $paymentMethod->delete();

            // Optional: Set another payment method as default if this was the default one
            if ($wasDefault) {
                $nextMethod = Auth::user()->paymentMethods()
                    ->active()
                    ->where('id', '!=', $paymentMethod->id)
                    ->first();
                    
                if ($nextMethod) {
                    $nextMethod->markAsDefault();
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Payment method deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete payment method: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get payment method types for form
     */
    public function getMethodTypes(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'method_types' => PaymentMethod::getMethodTypes()
        ]);
    }

    /**
     * Validate payment method data
     */
    private function validatePaymentMethod(Request $request, $paymentMethodId = null): \Illuminate\Validation\Validator
    {
        $rules = [
            'method_type' => ['required', 'string', Rule::in(array_keys(PaymentMethod::getMethodTypes()))],
            'method_name' => 'required|string|max:100',
            'account_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255',
            'bank_name' => 'nullable|string|max:255',
            'bank_country' => 'nullable|string|size:3',
            'account_details' => 'nullable|array',
            'account_identifier' => 'nullable|string|max:255',
            'currency' => 'required|string|size:3',
            'country_code' => 'required|string|size:3',
            'is_active' => 'boolean',
            'is_default' => 'boolean',
            'minimum_payout' => 'numeric|min:0|max:999999999999.99',
        ];

        // Method-specific validation
        $methodType = $request->input('method_type');
        
        if ($methodType === PaymentMethod::METHOD_PAYPAL) {
            $rules['email'] = 'required|email|max:255';
        } elseif ($methodType === PaymentMethod::METHOD_BANK_TRANSFER) {
            $rules['account_number'] = 'required|string|max:100';
            $rules['bank_name'] = 'required|string|max:255';
            $rules['account_name'] = 'required|string|max:255';
        } elseif ($methodType === PaymentMethod::METHOD_MOBILE_MONEY) {
            $rules['account_number'] = 'required|string|max:100';
        }

        return Validator::make($request->all(), $rules);
    }

    /**
     * Get payment methods for AJAX requests
     */
    public function getPaymentMethods(): JsonResponse
    {
        $paymentMethods = Auth::user()->paymentMethods()
            ->active()
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'payment_methods' => $paymentMethods
        ]);
    }

    /**
     * Get default payment method
     */
    public function getDefault(string $methodType = null): JsonResponse
    {
        $query = Auth::user()->paymentMethods()
            ->active()
            ->default();

        if ($methodType) {
            $query->byType($methodType);
        }

        $defaultMethod = $query->first();

        return response()->json([
            'success' => true,
            'default_method' => $defaultMethod
        ]);
    }

    /**
     * Bulk delete payment methods
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'required|integer|exists:payment_methods,id'
        ]);

        try {
            $userId = Auth::id();
            $ids = $request->input('ids');
            
            // Get payment methods that belong to the user
            $paymentMethods = PaymentMethod::whereIn('id', $ids)
                                          ->where('user_id', $userId)
                                          ->get();
            
            if ($paymentMethods->count() !== count($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Some payment methods not found or you do not have permission to delete them'
                ], 403);
            }
            
            // Check for restrictions (default methods, pending transactions, etc.)
            $restrictions = [];
            foreach ($paymentMethods as $method) {
                if ($method->is_default) {
                    $restrictions[] = "Cannot delete default payment method: {$method->method_name}";
                }
                
                // Add other business logic checks here
                // if ($method->hasPendingTransactions()) {
                //     $restrictions[] = "Cannot delete payment method with pending transactions: {$method->method_name}";
                // }
            }
            
            if (!empty($restrictions)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete some payment methods',
                    'restrictions' => $restrictions
                ], 422);
            }
            
            // Perform bulk delete
            $deletedCount = PaymentMethod::whereIn('id', $ids)
                                        ->where('user_id', $userId)
                                        ->delete();
            
            return response()->json([
                'success' => true,
                'message' => "{$deletedCount} payment method(s) deleted successfully",
                'deleted_count' => $deletedCount
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete payment methods: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check if payment method can be deleted
     */
    public function canDelete(PaymentMethod $paymentMethod): JsonResponse
    {
        $this->authorize('delete', $paymentMethod);
        
        $canDelete = true;
        $reasons = [];
        
        if ($paymentMethod->is_default) {
            $canDelete = false;
            $reasons[] = 'Cannot delete default payment method. Set another method as default first.';
        }
        
        // Add other business logic checks
        // if ($paymentMethod->hasPendingTransactions()) {
        //     $canDelete = false;
        //     $reasons[] = 'Cannot delete payment method with pending transactions';
        // }
        
        return response()->json([
            'can_delete' => $canDelete,
            'reasons' => $reasons
        ]);
    }

    /**
     * Mask account number for security
     */
    private function maskAccountNumber(?string $accountNumber): ?string
    {
        if (!$accountNumber || strlen($accountNumber) <= 4) {
            return $accountNumber;
        }

        $visibleChars = 4;
        $maskedLength = strlen($accountNumber) - $visibleChars;
        
        return str_repeat('*', $maskedLength) . substr($accountNumber, -$visibleChars);
    }
}