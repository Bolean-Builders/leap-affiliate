<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('category', 100);
            $table->enum('product_type', ['digital', 'physical', 'service']);
            $table->decimal('price', 10, 2);
            $table->decimal('commission', 5, 2); // Commission percentage
            $table->enum('status', ['active', 'pending', 'inactive', 'draft'])->default('pending');
            $table->string('featured_image')->nullable();
            $table->string('sales_page_url')->nullable();
            $table->string('resources_page_url')->nullable();
            $table->string('thankyou_page_url')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->json('tags')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['vendor_id', 'status']);
            $table->index(['category', 'status']);
            $table->index(['product_type', 'status']);
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};