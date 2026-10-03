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
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'author_id' => Author::factory(),
            'isbn' => $this->makeIsbn(),
            'title' => fake()->sentence(4),
            'published_year' => fake()->numberBetween(1450, now()->year),
            'is_reference' => fake()->boolean(15),
            'cover_path' => null,
        ];
    }

    private function makeIsbn(): string
    {
        $firstTwelveDigits = fake()->unique()->numerify('978#########');
        $sum = 0;

        for ($index = 0; $index < 12; $index++) {
            $sum += (int) $firstTwelveDigits[$index] * ($index % 2 === 0 ? 1 : 3);
        }

        return $firstTwelveDigits.(string) ((10 - ($sum % 10)) % 10);
    }
}
