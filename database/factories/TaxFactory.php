<?php

namespace Database\Factories;

use App\Models\Tax;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tax>
 */
class TaxFactory extends Factory
{
    protected $model = Tax::class;

    public function definition(): array
    {
        return [
            'name' => 'VAT '.$this->faker->randomElement([5,7.5,10]).'%',
            'rate' => $this->faker->randomFloat(2, 0, 25),
            'status' => 'ACTIVE',
        ];
    }
}

