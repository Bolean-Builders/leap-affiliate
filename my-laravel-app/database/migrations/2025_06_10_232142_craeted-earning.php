<?php

// Migration 1: create_user_earnings_summary_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_earnings_summary', function (Blueprint $table) {
            $table->id();
            
            // User Reference
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('user_type', ['affiliate', 'vendor']);
            
            // Core Earnings
            $table->decimal('total_lifetime_earnings', 15, 2)->default(0.00);
            $table->decimal('available_balance', 15, 2)->default(0.00);
            $table->decimal('pending_balance', 15, 2)->default(0.00);
            
            // Time-based Earnings
            $table->decimal('this_month_earnings', 15, 2)->default(0.00);
            $table->decimal('last_month_earnings', 15, 2)->default(0.00);
            $table->decimal('year_to_date_earnings', 15, 2)->default(0.00);
            
            // Payout Information
            $table->decimal('all_time_payout_total', 15, 2)->default(0.00);
            $table->integer('total_payouts_count')->default(0);
            $table->decimal('largest_single_payout', 15, 2)->default(0.00);
            $table->timestamp('last_payout_date')->nullable();
            
            // Performance Metrics
            $table->integer('current_earning_streak')->default(0);
            $table->integer('best_earning_streak')->default(0);
            $table->timestamp('last_earning_date')->nullable();
            $table->decimal('highest_daily_earning', 15, 2)->default(0.00);
            $table->decimal('average_monthly_earning', 15, 2)->default(0.00);
            
            // Monthly Reset Fields
            $table->integer('current_month')->default(0);
            $table->integer('current_year')->default(0);
            
            // Additional Tracking
            $table->integer('total_transactions')->default(0);
            $table->decimal('conversion_rate', 5, 2)->default(0.00);
            $table->decimal('average_order_value', 15, 2)->default(0.00);
            
            // Currency and Preferences
            $table->string('preferred_currency', 3)->default('USD');
            $table->decimal('minimum_payout_threshold', 15, 2)->default(10.00);
            
            // Status and Flags
            $table->boolean('is_payout_eligible')->default(true);
            $table->boolean('auto_payout_enabled')->default(false);
            $table->enum('earning_status', ['active', 'suspended', 'under_review'])->default('active');
            
            // Timestamps
            $table->timestamp('last_calculated_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index(['user_id', 'user_type']);
            $table->index('earning_status');
            $table->index(['available_balance', 'is_payout_eligible']);
            $table->unique(['user_id', 'user_type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_earnings_summary');
    }
};