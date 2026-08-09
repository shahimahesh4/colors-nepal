<?php

namespace Database\Factories;

use App\Models\PortfolioCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class PortfolioProjectFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->unique()->words(3, true);

        return ['portfolio_category_id' => PortfolioCategory::factory(), 'title' => str($title)->title(), 'slug' => str($title)->slug(), 'summary' => fake()->sentence(), 'content' => fake()->paragraphs(3, true), 'technologies' => ['Laravel', 'Tailwind CSS'], 'completed_at' => fake()->dateTimeBetween('-2 years'), 'status' => 'published', 'is_featured' => false, 'sort_order' => 0];
    }
}
