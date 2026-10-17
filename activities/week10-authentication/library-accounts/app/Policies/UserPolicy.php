<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function changeRole(User $user, User $target, string $newRole): bool
    {
        return $user->role === 'admin'
            && (! $user->is($target) || $newRole === 'admin');
    }
}
