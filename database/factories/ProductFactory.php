<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'brand_id' => Brand::factory(),
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'sku' => strtoupper($this->faker->unique()->bothify('SKU-#####')),
            'barcode' => $this->faker->ean13(),
            'status' => 'ACTIVE',
        ];
    }
}

