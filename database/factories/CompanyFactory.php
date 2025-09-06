<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Company>
 */
class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'region' => $this->faker->randomElement(['NA', 'EU', 'APAC', 'MEA', 'LATAM']),
            'office_address' => $this->faker->address(),
            'contact_no' => $this->faker->numerify('01#########'),
            'email' => $this->faker->unique()->safeEmail(),
            'status' => 'ACTIVE',
        ];
    }
}

