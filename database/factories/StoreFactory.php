<?php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Store>
 */
class StoreFactory extends Factory
{
    protected $model = Store::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company().' Store',
            'address' => $this->faker->address(),
            'status' => 'ACTIVE',
            'contact_no' => $this->faker->numerify('01#########'),
        ];
    }
}

