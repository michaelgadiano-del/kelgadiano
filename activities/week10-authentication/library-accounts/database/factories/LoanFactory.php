<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Loan>
 */
class LoanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'book_id' => Book::factory(),
            'member_id' => Member::factory(),
            'borrowed_at' => now()->subDays(fake()->numberBetween(1, 30)),
            'returned_at' => null,
        ];
    }
}
