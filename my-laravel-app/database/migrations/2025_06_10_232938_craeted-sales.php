<?php

// Migration: create_sales_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            // Core Info
            $table->id();
            $table->string('sale_reference', 50)->unique(); // "SALE001", "SALE002"
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            
            // User References (role validation handled in application layer)
            $table->foreignId('affiliate_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('vendor_id')->constrained('users')->onDelete('restrict');
            
            // Sale Details
            $table->string('customer_email');
            $table->string('customer_name');
            $table->decimal('sale_amount', 15, 2);
            $table->decimal('commission_rate', 5, 2); // Percentage (e.g., 15.50 for 15.5%)
            $table->decimal('commission_amount', 15, 2);
            
            // Sale Status
            $table->enum('status', ['pending', 'confirmed', 'refunded', 'cancelled'])->default('pending');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            
            // Tracking Info
            $table->string('referral_code_used')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->text('source_url')->nullable();
            
            // Financial
            $table->string('currency', 3)->default('USD');
            $table->decimal('exchange_rate', 10, 6)->default(1.000000);
            $table->decimal('processing_fee', 15, 2)->default(0.00);
            $table->decimal('net_sale_amount', 15, 2);
            
            // Timestamps
            $table->timestamp('sale_date');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('sale_reference');
            $table->index(['affiliate_id', 'status']);
            $table->index(['vendor_id', 'status']);
            $table->index(['status', 'payment_status']);
            $table->index('referral_code_used');
            $table->index('sale_date');
            $table->index(['customer_email', 'sale_date']);
            
            // Note: Role validation (affiliate_id must be user with role='affiliate', 
            // vendor_id must be user with role='vendor') is handled in the application 
            // layer via model validation to ensure database compatibility
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};