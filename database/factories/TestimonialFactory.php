<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TestimonialFactory extends Factory
{
    public function definition(): array
    {
        return ['name' => fake()->name(), 'role' => fake()->jobTitle(), 'company' => fake()->company(), 'content' => fake()->paragraph(), 'rating' => 5, 'status' => 'published', 'is_featured' => false, 'sort_order' => 0];
    }
}
