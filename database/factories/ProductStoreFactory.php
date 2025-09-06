<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductStore;
use App\Models\Store;
use App\Models\Tax;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductStore>
 */
class ProductStoreFactory extends Factory
{
    protected $model = ProductStore::class;

    public function definition(): array
    {
        $baseUnit = Unit::factory()->create();
        $purchaseUnit = Unit::factory()->create();
        $salesUnit = Unit::factory()->create();

        return [
            'store_id' => Store::factory(),
            'product_id' => Product::factory(),
            'base_unit_id' => $baseUnit->id,
            'purchase_unit_id' => $purchaseUnit->id,
            'sales_unit_id' => $salesUnit->id,
            'purchase_cost' => $this->faker->randomFloat(2, 1, 500),
            'cogs' => $this->faker->randomFloat(2, 1, 500),
            'sales_price' => $this->faker->randomFloat(2, 1, 1000),
            'status' => true,
            'tax_id' => Tax::factory(),
            'tax_method' => $this->faker->randomElement(['exclusive', 'inclusive']),
        ];
    }
}

