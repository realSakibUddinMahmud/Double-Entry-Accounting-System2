<?php

namespace Database\Factories;

use App\Models\Purchase;
use App\Models\Store;
use App\Models\Supplier;
use App\Models\Tax;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Purchase>
 */
class PurchaseFactory extends Factory
{
    protected $model = Purchase::class;

    public function definition(): array
    {
        $total = $this->faker->randomFloat(2, 10, 1000);
        $paid = $this->faker->randomFloat(2, 0, $total);

        return [
            'supplier_id' => Supplier::factory(),
            'store_id' => Store::factory(),
            'purchase_date' => now()->subDays($this->faker->numberBetween(0, 30)),
            'total_amount' => $total,
            'paid_amount' => $paid,
            'due_amount' => max(0, $total - $paid),
            'total_cost' => $total,
            'shipping_cost' => $this->faker->randomFloat(2, 0, 50),
            'discount_amount' => $this->faker->randomFloat(2, 0, 50),
            'tax_id' => Tax::factory(),
            'total_tax' => $this->faker->randomFloat(2, 0, 100),
            'status' => 1,
            'payment_status' => $paid >= $total ? 'PAID' : ($paid == 0 ? 'DUE' : 'PARTIAL'),
            'user_id' => User::factory(),
            'u_id' => strtoupper($this->faker->bothify('PUR-########')),
            'note' => $this->faker->sentence(),
        ];
    }
}

