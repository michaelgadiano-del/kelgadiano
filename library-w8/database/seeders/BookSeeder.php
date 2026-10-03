<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $catalogue = [
            'Jane Austen' => [
                ['title' => 'Sense and Sensibility', 'published_year' => 1811],
                ['title' => 'Pride and Prejudice', 'published_year' => 1813],
                ['title' => 'Mansfield Park', 'published_year' => 1814],
                ['title' => 'Emma', 'published_year' => 1815],
            ],
            'Charles Dickens' => [
                ['title' => 'Oliver Twist', 'published_year' => 1837],
                ['title' => 'A Christmas Carol', 'published_year' => 1843],
                ['title' => 'David Copperfield', 'published_year' => 1850],
                ['title' => 'Great Expectations', 'published_year' => 1861],
            ],
            'Mark Twain' => [
                ['title' => 'The Adventures of Tom Sawyer', 'published_year' => 1876],
                ['title' => 'The Prince and the Pauper', 'published_year' => 1881],
                ['title' => 'Adventures of Huckleberry Finn', 'published_year' => 1884],
                ['title' => 'A Connecticut Yankee in King Arthur\'s Court', 'published_year' => 1889],
            ],
            'Arthur Conan Doyle' => [
                ['title' => 'A Study in Scarlet', 'published_year' => 1887],
                ['title' => 'The Sign of the Four', 'published_year' => 1890],
                ['title' => 'The Adventures of Sherlock Holmes', 'published_year' => 1892],
                ['title' => 'The Hound of the Baskervilles', 'published_year' => 1902],
            ],
            'Louisa May Alcott' => [
                ['title' => 'Little Women', 'published_year' => 1868],
                ['title' => 'An Old-Fashioned Girl', 'published_year' => 1870],
                ['title' => 'Little Men', 'published_year' => 1871],
                ['title' => 'Jo\'s Boys', 'published_year' => 1886],
            ],
            'Jules Verne' => [
                ['title' => 'Journey to the Center of the Earth', 'published_year' => 1864],
                ['title' => 'Twenty Thousand Leagues Under the Sea', 'published_year' => 1870],
                ['title' => 'Around the World in Eighty Days', 'published_year' => 1873],
                ['title' => 'The Mysterious Island', 'published_year' => 1874],
            ],
            'Mary Shelley' => [
                ['title' => 'Frankenstein; or, The Modern Prometheus', 'published_year' => 1818],
                ['title' => 'Valperga', 'published_year' => 1823],
                ['title' => 'The Last Man', 'published_year' => 1826],
                ['title' => 'Lodore', 'published_year' => 1835],
            ],
            'Oscar Wilde' => [
                ['title' => 'The Happy Prince and Other Tales', 'published_year' => 1888],
                ['title' => 'The Picture of Dorian Gray', 'published_year' => 1890],
                ['title' => 'Lord Arthur Savile\'s Crime and Other Stories', 'published_year' => 1891],
                ['title' => 'The Importance of Being Earnest', 'published_year' => 1895],
            ],
            'Bram Stoker' => [
                ['title' => 'Dracula', 'published_year' => 1897],
                ['title' => 'The Jewel of Seven Stars', 'published_year' => 1903],
                ['title' => 'The Lady of the Shroud', 'published_year' => 1909],
                ['title' => 'The Lair of the White Worm', 'published_year' => 1911],
            ],
            'H. G. Wells' => [
                ['title' => 'The Time Machine', 'published_year' => 1895],
                ['title' => 'The Island of Doctor Moreau', 'published_year' => 1896],
                ['title' => 'The Invisible Man', 'published_year' => 1897],
                ['title' => 'The War of the Worlds', 'published_year' => 1898],
            ],
        ];

        $books = Book::query()->orderBy('id')->get();
        $bookIndex = 0;

        foreach ($catalogue as $authorName => $titles) {
            $author = Author::query()->firstOrCreate(['name' => $authorName]);

            foreach ($titles as $details) {
                $book = $books->get($bookIndex) ?? Book::factory()->make([
                    'author_id' => $author->id,
                ]);

                $book->author()->associate($author);
                $book->title = $details['title'];
                $book->published_year = $details['published_year'];
                $book->save();

                $bookIndex++;
            }
        }
    }
}
