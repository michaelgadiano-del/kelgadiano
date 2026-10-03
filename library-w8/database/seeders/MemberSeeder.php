<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Member;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = Member::factory()->count(30)->create();
        $bookIds = Book::query()->pluck('id')->all();
        $checkedOutBookIds = [];

        foreach ($members as $member) {
            $selectedBookIds = fake()->randomElements($bookIds, fake()->numberBetween(1, 3));

            foreach ($selectedBookIds as $bookId) {
                $borrowedAt = now()->subDays(fake()->numberBetween(1, 365));
                $isAlreadyCheckedOut = isset($checkedOutBookIds[$bookId]);
                $wasReturned = $isAlreadyCheckedOut || fake()->boolean(80);

                $member->books()->attach($bookId, [
                    'borrowed_at' => $borrowedAt,
                    'returned_at' => $wasReturned ? $borrowedAt->copy()->addDays(fake()->numberBetween(1, 30)) : null,
                ]);

                if (! $wasReturned) {
                    $checkedOutBookIds[$bookId] = true;
                }
            }
        }
    }
}
