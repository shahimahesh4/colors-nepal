<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->unique()->words(3, true);

        return ['title' => str($title)->title(), 'slug' => str($title)->slug(), 'summary' => fake()->sentence(), 'content' => fake()->paragraphs(3, true), 'status' => 'published', 'is_featured' => false, 'sort_order' => 0];
    }
}
