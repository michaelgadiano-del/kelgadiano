<?php

namespace App\Policies;

use App\Models\Author;
use App\Models\User;

class AuthorPolicy
{
    public function viewAny(?User $user): bool
    {
        return $user !== null && in_array($user->role, ['librarian', 'admin'], true);
    }

    public function update(User $user, Author $author): bool
    {
        return in_array($user->role, ['librarian', 'admin'], true);
    }
}
