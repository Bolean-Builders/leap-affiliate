<?php

namespace Database\Factories;

use App\Models\Sale;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    protected $model = Sale::class;

    public function definition(): array
    {
        $saleAmount = $this->faker->randomFloat(2, 10, 1000);
        $commissionRate = $this->faker->randomFloat(2, 5, 25);
        $processingFee = $saleAmount * 0.029; // 2.9% processing fee
        
        return [
            'product_id' => Product::factory(),
            'affiliate_id' => User::factory()->state(['role' => 'affiliate']),
            'vendor_id' => User::factory()->state(['role' => 'vendor']),
            'customer_email' => $this->faker->email(),
            'customer_name' => $this->faker->name(),
            'sale_amount' => $saleAmount,
            'commission_rate' => $commissionRate,
            'commission_amount' => ($saleAmount * $commissionRate) / 100,
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'refunded', 'cancelled']),
            'payment_status' => $this->faker->randomElement(['pending', 'paid', 'failed', 'refunded']),
            'referral_code_used' => $this->faker->optional()->lexify('REF????'),
            'ip_address' => $this->faker->ipv4(),
            'user_agent' => $this->faker->userAgent(),
            'source_url' => $this->faker->url(),
            'currency' => 'USD',
            'exchange_rate' => 1.000000,
            'processing_fee' => $processingFee,
            'net_sale_amount' => $saleAmount - $processingFee,
            'sale_date' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }

    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'confirmed',
            'confirmed_at' => $this->faker->dateTimeBetween($attributes['sale_date'] ?? '-1 month', 'now'),
        ]);
    }

    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'payment_status' => 'paid',
        ]);
    }

    public function thisMonth(): static
    {
        return $this->state(fn (array $attributes) => [
            'sale_date' => $this->faker->dateTimeBetween(now()->startOfMonth(), now()),
        ]);
    }
}