<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TeamMemberFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->name();

        return ['name' => $name, 'slug' => str($name)->slug(), 'role' => fake()->jobTitle(), 'bio' => fake()->paragraph(), 'email' => fake()->unique()->safeEmail(), 'status' => 'published', 'sort_order' => 0];
    }
}
