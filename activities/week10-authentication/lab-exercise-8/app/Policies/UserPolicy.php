<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function renameInstructor(User $user, User $instructor): bool
    {
        return $user->isAdmin() && $instructor->isInstructor();
    }
}
