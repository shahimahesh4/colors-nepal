<?php

namespace Database\Factories;

use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogPostFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->unique()->sentence(5);

        return ['user_id' => User::factory(), 'blog_category_id' => BlogCategory::factory(), 'title' => $title, 'slug' => str($title)->slug(), 'excerpt' => fake()->sentence(), 'content' => fake()->paragraphs(5, true), 'status' => 'published', 'published_at' => now()];
    }
}
