<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
            'Jane Austen',
            'Charles Dickens',
            'Mark Twain',
            'Arthur Conan Doyle',
            'Louisa May Alcott',
            'Jules Verne',
            'Mary Shelley',
            'Oscar Wilde',
            'Bram Stoker',
            'H. G. Wells',
        ];

        $authors = Author::query()->orderBy('id')->get();

        foreach ($names as $index => $name) {
            $author = $authors->get($index) ?? new Author;
            $author->name = $name;
            $author->save();
        }
    }
}
