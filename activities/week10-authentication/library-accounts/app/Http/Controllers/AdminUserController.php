<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRoleRequest;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::with('member')->orderBy('role')->orderBy('name')->get();

        return view('admin.users', compact('users'));
    }

    public function updateRole(UpdateUserRoleRequest $request, User $user)
    {
        Gate::authorize('changeRole', [$user, $request->validated('role')]);
        $user->forceFill(['role' => $request->validated('role')])->save();

        return back()->with('status', 'User role updated.');
    }
}
