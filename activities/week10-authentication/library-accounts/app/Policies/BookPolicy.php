<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;

class BookPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        return $user->role === 'admin' ? true : null;
    }

    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Book $book): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->role === 'librarian';
    }

    public function update(User $user, Book $book): bool
    {
        return $user->role === 'librarian';
    }

    public function delete(User $user, Book $book): bool
    {
        return $user->role === 'librarian';
    }

    public function borrow(User $user, Book $book): bool
    {
        return $user->role === 'member' && ! $book->is_reference;
    }
}
