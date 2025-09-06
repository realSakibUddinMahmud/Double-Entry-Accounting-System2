<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Sale;
use App\Models\Store;
use App\Models\Tax;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Sale>
 */
class SaleFactory extends Factory
{
    protected $model = Sale::class;

    public function definition(): array
    {
        $total = $this->faker->randomFloat(2, 10, 1000);
        $paid = $this->faker->randomFloat(2, 0, $total);

        return [
            'u_id' => strtoupper($this->faker->bothify('SAL-########')),
            'store_id' => Store::factory(),
            'customer_id' => Customer::factory(),
            'sale_date' => now()->subDays($this->faker->numberBetween(0, 30)),
            'total_amount' => $total,
            'paid_amount' => $paid,
            'due_amount' => max(0, $total - $paid),
            'total_price' => $total,
            'shipping_cost' => $this->faker->randomFloat(2, 0, 50),
            'discount_amount' => $this->faker->randomFloat(2, 0, 50),
            'tax_id' => Tax::factory(),
            'total_tax' => $this->faker->randomFloat(2, 0, 100),
            'status' => 1,
            'payment_status' => $paid >= $total ? 'PAID' : ($paid == 0 ? 'DUE' : 'PARTIAL'),
            'user_id' => User::factory(),
            'note' => $this->faker->sentence(),
        ];
    }
}

