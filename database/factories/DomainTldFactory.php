<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DomainTldFactory extends Factory
{
    public function definition(): array
    {
        return ['extension' => '.'.fake()->unique()->lexify('???'), 'registration_price' => 150000, 'renewal_price' => 180000, 'currency' => 'NPR', 'is_active' => true, 'sort_order' => 0];
    }
}
