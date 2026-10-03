<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterMemberRequest;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MemberRegistrationController extends Controller
{
    public function create(): View
    {
        return view('members.create');
    }

    public function store(RegisterMemberRequest $request): RedirectResponse
    {
        Member::create($request->validated());

        return redirect()->route('books.index')->with('status', 'Member registered.');
    }
}
