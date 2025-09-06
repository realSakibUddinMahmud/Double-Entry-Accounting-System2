<?php

namespace Database\Factories;

use App\Models\CustomField;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CustomField>
 */
class CustomFieldFactory extends Factory
{
    protected $model = CustomField::class;

    public function definition(): array
    {
        return [
            'model_type' => \App\Models\Product::class,
            'name' => $this->faker->unique()->slug(),
            'label' => $this->faker->words(2, true),
            'type' => $this->faker->randomElement(['text','number','select']),
            'options' => 'A,B,C',
        ];
    }
}

