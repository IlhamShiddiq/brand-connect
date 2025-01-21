<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Outlet>
 */
class OutletFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $brand = Brand::factory()->create();

        return [
            'brand_id' => $brand->id,
            'name' => fake()->company,
            'phone_number' => fake()->phoneNumber,
            'description' => fake()->sentence,
            'address' => fake()->address,
            'latitude' => fake()->latitude,
            'longitude' => fake()->longitude,
        ];
    }
}
