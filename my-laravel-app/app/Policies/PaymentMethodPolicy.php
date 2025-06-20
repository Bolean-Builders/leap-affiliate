<?php

namespace App\Policies;

use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentMethodPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any payment methods.
     */
    public function viewAny(User $user): bool
    {
        return true; // Users can view their own payment methods
    }

    /**
     * Determine whether the user can view the payment method.
     */
    public function view(User $user, PaymentMethod $paymentMethod): bool
    {
        return $user->id === $paymentMethod->user_id;
    }

    /**
     * Determine whether the user can create payment methods.
     */
    public function create(User $user): bool
    {
        return true; // All authenticated users can create payment methods
    }

    /**
     * Determine whether the user can update the payment method.
     */
    public function update(User $user, PaymentMethod $paymentMethod): bool
    {
        return $user->id === $paymentMethod->user_id;
    }

    /**
     * Determine whether the user can delete the payment method.
     */
    public function delete(User $user, PaymentMethod $paymentMethod): bool
    {
        // User must own the payment method
        if ($user->id !== $paymentMethod->user_id) {
            return false;
        }

        // Additional business logic: Cannot delete if it's the only payment method
        $userPaymentMethodsCount = PaymentMethod::where('user_id', $user->id)
            ->where('id', '!=', $paymentMethod->id)
            ->count();

        // Allow deletion if user has other payment methods or if it's not default
        return $userPaymentMethodsCount > 0 || !$paymentMethod->is_default;
    }

    /**
     * Determine whether the user can restore the payment method.
     */
    public function restore(User $user, PaymentMethod $paymentMethod): bool
    {
        return $user->id === $paymentMethod->user_id;
    }

    /**
     * Determine whether the user can permanently delete the payment method.
     */
    public function forceDelete(User $user, PaymentMethod $paymentMethod): bool
    {
        return $user->id === $paymentMethod->user_id;
    }

    /**
     * Determine whether the user can set the payment method as default.
     */
    public function setDefault(User $user, PaymentMethod $paymentMethod): bool
    {
        return $user->id === $paymentMethod->user_id && $paymentMethod->is_active;
    }

    /**
     * Determine whether the user can activate/deactivate the payment method.
     */
    public function toggleActive(User $user, PaymentMethod $paymentMethod): bool
    {
        return $user->id === $paymentMethod->user_id;
    }

    /**
     * Determine whether the user can verify the payment method.
     * This would typically be for admin users only.
     */
    public function verify(User $user, PaymentMethod $paymentMethod): bool
    {
        return $user->hasRole('admin') || $user->hasRole('super_admin');
    }

    /**
     * Determine whether the user can perform bulk operations.
     */
    public function bulkDelete(User $user): bool
    {
        return true; // Users can bulk delete their own payment methods
    }
}