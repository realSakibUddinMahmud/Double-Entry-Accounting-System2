<?php

namespace Database\Factories;

use App\Models\StockAdjustment;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StockAdjustment>
 */
class StockAdjustmentFactory extends Factory
{
    protected $model = StockAdjustment::class;

    public function definition(): array
    {
        return [
            'store_id' => Store::factory(),
            'date' => now()->subDays($this->faker->numberBetween(0, 15)),
            'note' => $this->faker->sentence(),
            'user_id' => User::factory(),
        ];
    }
}

