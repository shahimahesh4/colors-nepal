<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFaqFactory extends Factory
{
    public function definition(): array
    {
        return ['service_id' => Service::factory(), 'question' => fake()->sentence().'?', 'answer' => fake()->paragraph(), 'sort_order' => 0];
    }
}
