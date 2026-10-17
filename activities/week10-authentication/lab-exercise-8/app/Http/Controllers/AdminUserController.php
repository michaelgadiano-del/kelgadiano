<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateInstructorNameRequest;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class AdminUserController extends Controller
{
    public function updateInstructorName(UpdateInstructorNameRequest $request, User $user)
    {
        Gate::authorize('renameInstructor', $user);
        $user->update(['name' => $request->validated('name')]);

        return back()->with('status', 'Instructor name updated.');
    }
}
