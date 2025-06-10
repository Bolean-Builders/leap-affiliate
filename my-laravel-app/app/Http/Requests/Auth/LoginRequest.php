<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'login' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    // Check if user exists (by email or username)
                    $user = $this->findUser($value);
                    if (!$user) {
                        $fail('These credentials do not match our records.');
                        return;
                    }
                }
            ],
            'password' => [
                'required',
                'string',
                'min:6',
                'max:255'
            ],
            'remember' => [
                'nullable',
                'boolean'
            ]
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'login.required' => 'The email or username field is required.',
            'login.max' => 'The email or username must not exceed 255 characters.',
            'password.required' => 'The password field is required.',
            'password.min' => 'Password must be at least 6 characters long.',
            'password.max' => 'Password must not exceed 255 characters.',
        ];
    }

    /**
     * Get custom validation attributes.
     */
    public function attributes(): array
    {
        return [
            'login' => 'email or username',
            'password' => 'password',
            'remember' => 'remember me',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Check rate limiting
            if ($this->hasTooManyAttempts()) {
                $seconds = $this->getSecondsUntilAvailable();
                $validator->errors()->add(
                    'login',
                    "Too many login attempts. Please try again in {$seconds} seconds."
                );
            }
        });
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator): void
    {
        // If this is an AJAX request, return JSON response
        if ($this->expectsJson()) {
            $response = response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);

            throw new \Illuminate\Validation\ValidationException($validator, $response);
        }

        parent::failedValidation($validator);
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'login' => strtolower(trim($this->login)),
            'remember' => $this->boolean('remember'),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::lower($this->input('login')) . '|' . $this->ip();
    }

    /**
     * Determine if the user has too many failed login attempts.
     */
    public function hasTooManyAttempts(): bool
    {
        return RateLimiter::tooManyAttempts($this->throttleKey(), 5);
    }

    /**
     * Get the number of seconds until the next attempt is available.
     */
    public function getSecondsUntilAvailable(): int
    {
        return RateLimiter::availableIn($this->throttleKey());
    }

    /**
     * Increment the login attempts for the user.
     */
    public function incrementAttempts(): void
    {
        RateLimiter::hit($this->throttleKey(), 900); // 15 minutes lockout
    }

    /**
     * Clear the login locks for the given user credentials.
     */
    public function clearAttempts(): void
    {
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Get the credentials for authentication.
     */
    public function getCredentials(): array
    {
        $login = $this->input('login');
        $field = $this->getLoginField($login);

        return [
            $field => $login,
            'password' => $this->input('password')
        ];
    }

    /**
     * Check if remember me is enabled.
     */
    public function shouldRemember(): bool
    {
        return $this->boolean('remember');
    }

    /**
     * Find user by email or username.
     */
    public function findUser(string $login): ?User
    {
        return User::where('email', $login)
                   ->orWhere('username', $login)
                   ->first();
    }

    /**
     * Determine if the login input is email or username.
     */
    public function getLoginField(string $login): string
    {
        return filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    }

    /**
     * Sanitize and get the login input.
     */
    public function getLoginInput(): string
    {
        return strtolower(trim($this->input('login')));
    }

    /**
     * Get the user instance for the given credentials.
     */
    public function findUserInstance(): ?User
    {
        return $this->findUser($this->getLoginInput());
    }

    /**
     * Check if the login attempt should be throttled.
     */
    public function shouldThrottle(): bool
    {
        return $this->hasTooManyAttempts();
    }

    /**
     * Get user role after successful authentication.
     */
    public function getUserRole(): ?string
    {
        $user = $this->findUserInstance();
        return $user ? $user->role : null;
    }

    /**
     * Get user type after successful authentication.
     */
    public function getUserType(): ?string
    {
        $user = $this->findUserInstance();
        return $user ? $user->user_type : null;
    }

    /**
     * Update user's last login information.
     */
    public function updateLastLogin(): void
    {
        $user = $this->findUserInstance();
        if ($user) {
            $user->update([
                'last_login_at' => now(),
                'last_login_ip' => $this->ip()
            ]);
        }
    }
}