<?php

// Migration: create_payment_methods_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            // Core Info
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('method_type', ['paypal', 'bank_transfer', 'stripe', 'wise', 'crypto', 'mobile_money']);
            $table->string('method_name', 100); // "My PayPal", "Main Bank Account"
            
            // Primary Account Details (Direct Fields)
            $table->string('account_name')->nullable(); // Account holder name
            $table->string('account_number', 100)->nullable(); // Bank account number or identifier
            $table->string('email')->nullable(); // For PayPal, Wise, etc.
            $table->string('bank_name')->nullable(); // Bank institution name
            $table->string('bank_country', 3)->nullable(); // ISO 3166-1 alpha-3 country code for bank
            
            // Extended Account Details
            $table->json('account_details')->nullable(); // Additional method-specific information
            $table->string('account_identifier')->nullable(); // Main identifier for quick access
            $table->string('currency', 3)->default('USD'); // ISO 4217 currency code
            $table->string('country_code', 3); // ISO 3166-1 alpha-3 country code
            
            // Status & Settings
            $table->boolean('is_active')->default(true);
            $table->boolean('is_default')->default(false);
            $table->boolean('is_verified')->default(false);
            $table->decimal('minimum_payout', 15, 2)->default(10.00);
            
            // Verification
            $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->text('verification_notes')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            
            // Usage Tracking
            $table->timestamp('last_used_at')->nullable();
            $table->integer('total_payouts')->default(0);
            $table->decimal('total_amount', 15, 2)->default(0.00);
            
            // Timestamps
            $table->timestamps();
            
            // Indexes
            $table->index(['user_id', 'is_active', 'is_default']);
            $table->index('method_type');
            $table->index('verification_status');
            
            // Unique constraint for default method per user per type
            $table->unique(['user_id', 'method_type'], 'unique_user_method_default')
                  ->where('is_default', true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_methods');
    }
};