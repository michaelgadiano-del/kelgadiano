<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    public function definition(): array
    {
        return [
            'author_id' => Author::factory(),
            'isbn' => fake()->unique()->numerify('#############'),
            'title' => fake()->sentence(4),
            'published_year' => fake()->numberBetween(1950, (int) date('Y')),
            'is_reference' => false,
            'cover_path' => null,
        ];
    }
}
