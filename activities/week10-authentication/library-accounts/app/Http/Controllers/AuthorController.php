<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAuthorNameRequest;
use App\Models\Author;
use Illuminate\Support\Facades\Gate;

class AuthorController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Author::class);
        $authors = Author::withCount('books')->orderBy('name')->get();

        return view('authors.index', compact('authors'));
    }

    public function update(UpdateAuthorNameRequest $request, Author $author)
    {
        Gate::authorize('update', $author);
        $author->update($request->validated());

        return back()->with('status', 'Author name updated.');
    }
}
