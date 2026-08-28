<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(): View
    {
        $students = User::all();

        return view('students.index', compact('students'));
    }

    public function create(): View
    {
        return view('students.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
        ]);

        User::create([
            ...$data,
            'password' => Hash::make(Str::random(32)),
        ]);

        return redirect()
            ->route('students.index')
            ->with('success', 'Student added successfully.');
    }

    public function show(User $student): View
    {
        return view('students.show', ['user' => $student]);
    }

    public function edit(User $student): View
    {
        return view('students.edit', ['user' => $student]);
    }

    public function update(Request $request, User $student): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'unique:users,email,' . $student->id,
            ],
        ]);

        $student->update($data);

        return redirect()
            ->route('students.show', $student)
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(User $student): RedirectResponse
    {
        $student->delete();

        return redirect()
            ->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }
}