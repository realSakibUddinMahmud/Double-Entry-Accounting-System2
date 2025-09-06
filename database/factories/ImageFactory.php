<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Image>
 */
class ImageFactory extends Factory
{
    protected $model = Image::class;

    public function definition(): array
    {
        // Default to Product image; callers can override model/type
        $imageable = Product::factory()->create();

        return [
            'imageable_type' => get_class($imageable),
            'imageable_id' => $imageable->id,
            'path' => 'uploads/'.$this->faker->uuid().'.jpg',
            'mime' => 'image/jpeg',
            'size' => $this->faker->numberBetween(10_000, 500_000),
        ];
    }
}

