<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence();
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => fake()->paragraphs(4, true),
            'status' => fake()->randomElement(['draft', 'published', 'scheduled']),
            'published_at' => fake()->dateTimeBetween('-1 month', '+1 month'),
        ];
    }
}