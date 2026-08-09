<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FaqFactory extends Factory
{
    public function definition(): array
    {
        return ['group' => 'general', 'question' => fake()->sentence().'?', 'answer' => fake()->paragraph(), 'status' => 'published', 'sort_order' => 0];
    }
}
