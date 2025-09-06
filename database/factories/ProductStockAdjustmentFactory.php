<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductStockAdjustment;
use App\Models\StockAdjustment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductStockAdjustment>
 */
class ProductStockAdjustmentFactory extends Factory
{
    protected $model = ProductStockAdjustment::class;

    public function definition(): array
    {
        return [
            'stock_adjustment_id' => StockAdjustment::factory(),
            'product_id' => Product::factory(),
            'action' => $this->faker->randomElement(['+','-']),
            'quantity' => $this->faker->randomFloat(2, 1, 10),
            'user_id' => User::factory(),
        ];
    }
}

