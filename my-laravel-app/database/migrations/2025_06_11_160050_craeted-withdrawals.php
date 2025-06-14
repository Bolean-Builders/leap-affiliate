<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            
            // User references - one will be null based on role
            $table->foreignId('vendor_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('affiliate_id')->nullable()->constrained('users')->onDelete('cascade');
            
            // Amount and date
            $table->decimal('amount', 15, 2);
            $table->date('date');
            
            // Status
            $table->enum('status', [
                'pending',
                'approved',
                'processing',
                'completed',
                'rejected',
                'cancelled'
            ])->default('pending');
            
            $table->timestamps();
            
            // Indexes
            $table->index('vendor_id');
            $table->index('affiliate_id');
            $table->index(['status', 'date']);
            
            // Ensure only one of vendor_id or affiliate_id is set
            $table->index(['vendor_id', 'affiliate_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('withdrawals');
    }
};