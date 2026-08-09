<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFeatureFactory extends Factory
{
    public function definition(): array
    {
        return ['service_id' => Service::factory(), 'title' => fake()->sentence(4), 'description' => fake()->sentence(), 'sort_order' => 0];
    }
}
