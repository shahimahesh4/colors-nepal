<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class QuoteRequestFactory extends Factory
{
    public function definition(): array
    {
        return ['name' => fake()->name(), 'email' => fake()->safeEmail(), 'phone' => fake()->phoneNumber(), 'company' => fake()->company(), 'services' => ['Website Design & Development'], 'budget_min' => 5000000, 'budget_max' => 15000000, 'currency' => 'NPR', 'timeline' => '1-3 months', 'message' => fake()->paragraph(), 'status' => 'new'];
    }
}
