<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Tax;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PurchaseItem>
 */
class PurchaseItemFactory extends Factory
{
    protected $model = PurchaseItem::class;

    public function definition(): array
    {
        $qty = $this->faker->randomFloat(2, 1, 10);
        $cost = $this->faker->randomFloat(2, 1, 100);
        $taxAmt = $this->faker->randomFloat(2, 0, 10);
        $disc = $this->faker->randomFloat(2, 0, 5);

        return [
            'purchase_id' => Purchase::factory(),
            'product_id' => Product::factory(),
            'unit_id' => Unit::factory(),
            'tax_id' => Tax::factory(),
            'tax_amount' => $taxAmt,
            'discount_amount' => $disc,
            'quantity' => $qty,
            'per_unit_cost' => $cost,
            'per_unit_cogs' => $cost,
            'total' => $qty * $cost + $taxAmt - $disc,
        ];
    }
}

