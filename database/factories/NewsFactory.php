<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory {
    
    public function definition(): array {
        return [
            'source' => $this->faker->company(),
            'author' => $this->faker->name(),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'url' => $this->faker->unique()->url(),
            'url_to_image' => $this->faker->imageUrl(800, 400, 'news'),
            'published_at' => $this->faker->dateTimeBetween('-7 days','now'),
            'content' => $this->faker->paragraphs(2, true),
            'category' => 'technology',
        ];
    }
}