<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BookController extends Controller
{
    public function index(): View
    {
        return view('books.index', [
            'books' => Book::with('author')->withCount([
                'members as active_loans_count' => fn ($query) => $query->whereNull('book_member.returned_at'),
            ])->orderBy('title')->get(),
        ]);
    }

    public function create(): View
    {
        return view('books.create', [
            'book' => new Book,
            'authors' => Author::orderBy('name')->get(),
        ]);
    }

    public function store(StoreBookRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('cover')) {
            $data['cover_path'] = $request->file('cover')->store('covers', 'public');
        }

        unset($data['cover']);
        $book = Book::create($data);

        return redirect()->route('books.show', $book)->with('status', 'Book added to the catalogue.');
    }

    public function show(Book $book): View
    {
        $book->load('author');

        return view('books.show', [
            'book' => $book,
            'members' => Member::orderBy('name')->get(),
            'currentLoan' => $book->members()->wherePivotNull('returned_at')->first(),
        ]);
    }

    public function edit(Book $book): View
    {
        return view('books.edit', [
            'book' => $book,
            'authors' => Author::orderBy('name')->get(),
        ]);
    }

    public function update(UpdateBookRequest $request, Book $book): RedirectResponse
    {
        $data = $request->validated();
        $previousCoverPath = $book->cover_path;

        if ($request->hasFile('cover')) {
            $data['cover_path'] = $request->file('cover')->store('covers', 'public');
        }

        unset($data['cover']);
        $book->update($data);

        if ($previousCoverPath && isset($data['cover_path'])) {
            Storage::disk('public')->delete($previousCoverPath);
        }

        return redirect()->route('books.show', $book)->with('status', 'Book updated.');
    }
}
