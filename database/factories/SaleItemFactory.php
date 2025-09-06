<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Tax;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SaleItem>
 */
class SaleItemFactory extends Factory
{
    protected $model = SaleItem::class;

    public function definition(): array
    {
        $qty = $this->faker->randomFloat(2, 1, 10);
        $price = $this->faker->randomFloat(2, 1, 150);
        $taxAmt = $this->faker->randomFloat(2, 0, 10);
        $disc = $this->faker->randomFloat(2, 0, 5);

        return [
            'sale_id' => Sale::factory(),
            'product_id' => Product::factory(),
            'unit_id' => Unit::factory(),
            'tax_id' => Tax::factory(),
            'tax_amount' => $taxAmt,
            'discount_amount' => $disc,
            'quantity' => $qty,
            'per_unit_price' => $price,
            'per_unit_cogs' => $price * 0.6,
            'total' => $qty * $price + $taxAmt - $disc,
        ];
    }
}

