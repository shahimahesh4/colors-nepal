<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class HostingPlanFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->word().' Hosting';

        return ['name' => str($name)->title(), 'slug' => str($name)->slug(), 'description' => fake()->sentence(), 'features' => ['SSL certificate', 'Daily backup'], 'monthly_price' => 50000, 'yearly_price' => 500000, 'currency' => 'NPR', 'status' => 'published', 'is_featured' => false, 'sort_order' => 0];
    }
}
