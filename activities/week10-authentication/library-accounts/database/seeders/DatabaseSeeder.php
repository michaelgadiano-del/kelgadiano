<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private const BOOK_TITLES = [
        'A Map of Old Manila',
        'Letters from the Rainy Season',
        'The Last Jeepney Home',
        'Stories from the Pasig River',
        'Small Gardens in the City',
        'A Beginner’s Guide to Filipino Cooking',
        'The Art of Listening',
        'Everyday Mathematics',
        'A History of Philippine Cinema',
        'The Night Market',
        'The Quiet Library',
        'Notes from a Young Teacher',
        'Building Better Habits',
        'The Science of Sleep',
        'A Field Guide to Local Birds',
        'The Family Recipe Book',
        'Public Speaking for Students',
        'Drawing the World Around You',
        'The First Day of Class',
        'A Practical Guide to Research',
        'Women Who Changed Philippine History',
        'The Old House on Mabini Street',
        'Learning English Through Stories',
        'An Introduction to Web Design',
        'The Community Garden Project',
        'Understanding Climate Change',
        'A Walk Through Intramuros',
        'The Little Book of Astronomy',
        'Cooking for a Small Family',
        'The School Newspaper',
        'Finding Your Voice',
        'The River Between Two Towns',
        'Simple Projects with Arduino',
        'The Bookshop at the Corner',
        'A Student’s Guide to Public Service',
        'Philippine Folk Tales for Today',
        'The Basics of Financial Literacy',
        'A Place to Call Home',
        'How to Read a Map',
        'The School Library Handbook',
    ];

    public function run(): void
    {
        $makeUser = static function (string $name, string $email, string $role): User {
            $user = User::factory()->create(compact('name', 'email'));
            $user->forceFill(['role' => $role])->save();

            return $user;
        };

        $makeUser('Admin User', 'admin@example.com', 'admin');
        $makeUser('Library Staff', 'librarian@example.com', 'librarian');
        $memberUser = $makeUser('Sample Member', 'member@example.com', 'member');

        $authors = Author::factory(10)->create();
        $books = collect();
        $titleIndex = 0;

        foreach ($authors as $author) {
            foreach (range(1, 4) as $_) {
                $books->push(Book::factory()->for($author)->create([
                    'title' => self::BOOK_TITLES[$titleIndex++],
                ]));
            }
        }

        $books->first()->update(['is_reference' => true]);
        $circulatingBooks = $books->where('is_reference', false);

        $members = collect([
            $memberUser->member()->create([
                'name' => $memberUser->name,
                'email' => $memberUser->email,
            ]),
        ]);

        $members = $members->concat(Member::factory(29)->create());

        $loanIds = [];
        foreach ($members as $member) {
            foreach (range(1, fake()->numberBetween(1, 3)) as $_) {
                $loan = $member->loans()->create([
                    'book_id' => $circulatingBooks->random()->id,
                    'borrowed_at' => now()->subDays($daysAgo = fake()->numberBetween(1, 30)),
                    'returned_at' => now()->subDays(max(1, $daysAgo - 1)),
                ]);
                $loanIds[] = $loan->id;
            }
        }

        shuffle($loanIds);
        $unreturnedCount = (int) round(count($loanIds) * 0.2);

        Loan::whereKey(array_slice($loanIds, 0, $unreturnedCount))
            ->update(['returned_at' => null]);
    }
}
