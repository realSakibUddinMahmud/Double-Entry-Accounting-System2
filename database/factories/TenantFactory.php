<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Multitenancy\Models\Tenant;

/**
 * @extends Factory<Tenant>
 */
class TenantFactory extends Factory
{
    protected $model = Tenant::class;

    public function definition(): array
    {
        $db = 'tenant_'.strtolower($this->faker->bothify('????_#####'));
        return [
            'company_id' => 1,
            'name' => $this->faker->company(),
            'domain' => $this->faker->randomElement(['127.0.0.1','localhost']),
            'database' => $db,
        ];
    }
}

