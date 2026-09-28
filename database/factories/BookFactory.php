<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'author' => $this->faker->name(),
            'publisher' => $this->faker->company(),
            'year' => $this->faker->year(),
            'category_id' => \App\Models\Category::inRandomOrder()->first()?->id ?? \App\Models\Category::factory()->create()->id,
            'shelf_id' => \App\Models\Shelf::inRandomOrder()->first()?->id ?? \App\Models\Shelf::factory()->create()->id,
            'stock_total' => $this->faker->numberBetween(1, 10),
            'description' => $this->faker->paragraph(),
            'cover_image' => null,
        ];
    }
}
