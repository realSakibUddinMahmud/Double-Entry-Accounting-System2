<?php

namespace Database\Factories;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Unit>
 */
class UnitFactory extends Factory
{
    protected $model = Unit::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Piece','Box','Kg','Litre']),
            'symbol' => $this->faker->randomElement(['pc','box','kg','l']),
            'parent_id' => null,
            'conversion_factor' => 1,
        ];
    }
}

