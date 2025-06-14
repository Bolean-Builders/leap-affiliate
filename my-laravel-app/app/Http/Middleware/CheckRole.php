<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to access this page.');
        }

        // Get the authenticated user
        $user = auth()->user();

        // Check if user has a role property/column
        if (!isset($user->role)) {
            abort(500, 'User role not defined. Please contact administrator.');
        }

        // Check if user has the required role
        if ($user->role !== $role) {
            abort(403, 'Access denied. You do not have permission to access this resource.');
        }

        return $next($request);
    }
}