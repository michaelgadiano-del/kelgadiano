<?php

namespace App\Policies;

use App\Models\Loan;
use App\Models\User;

class LoanPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        return $user->role === 'admin' ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['member', 'librarian'], true);
    }

    public function view(User $user, Loan $loan): bool
    {
        return $user->role === 'librarian'
            || ($user->role === 'member' && $user->member?->id === $loan->member_id);
    }

    public function markReturned(User $user, Loan $loan): bool
    {
        return $user->role === 'librarian';
    }
}
