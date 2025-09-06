<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Customer>
 */
class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'phone' => $this->faker->numerify('01#########'),
            'email' => $this->faker->safeEmail(),
            'address' => $this->faker->address(),
            'status' => 'ACTIVE',
        ];
    }
}

