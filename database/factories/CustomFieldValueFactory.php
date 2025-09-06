<?php

namespace Database\Factories;

use App\Models\CustomField;
use App\Models\CustomFieldValue;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CustomFieldValue>
 */
class CustomFieldValueFactory extends Factory
{
    protected $model = CustomFieldValue::class;

    public function definition(): array
    {
        $product = Product::factory()->create();
        return [
            'model_type' => get_class($product),
            'model_id' => $product->id,
            'custom_field_id' => CustomField::factory(),
            'value' => $this->faker->word(),
        ];
    }
}

