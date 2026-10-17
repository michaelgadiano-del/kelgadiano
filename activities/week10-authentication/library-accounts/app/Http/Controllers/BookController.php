<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class BookController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Book::class);
        $books = Book::with('author')->orderBy('title')->get();

        return view('books.index', compact('books'));
    }

    public function create()
    {
        Gate::authorize('create', Book::class);
        $book = new Book(['published_year' => date('Y'), 'is_reference' => false]);
        $authors = Author::orderBy('name')->get();

        return view('books.form', compact('book', 'authors'));
    }

    public function store(BookRequest $request)
    {
        Gate::authorize('create', Book::class);
        $book = Book::create($request->validated());

        return redirect()->route('books.show', $book)->with('status', 'Book added.');
    }

    public function show(Book $book)
    {
        Gate::authorize('view', $book);
        $book->load('author')->loadCount(['loans as active_loans_count' => fn ($query) => $query->whereNull('returned_at')]);

        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        Gate::authorize('update', $book);
        $authors = Author::orderBy('name')->get();

        return view('books.form', compact('book', 'authors'));
    }

    public function update(BookRequest $request, Book $book)
    {
        Gate::authorize('update', $book);
        $book->update($request->validated());

        return redirect()->route('books.show', $book)->with('status', 'Book updated.');
    }

    public function destroy(Book $book)
    {
        Gate::authorize('delete', $book);
        $book->delete();

        return redirect()->route('books.index')->with('status', 'Book deleted.');
    }

    public function borrow(Request $request, Book $book)
    {
        Gate::authorize('borrow', $book);
        $member = $request->user()->member;

        abort_unless($member, 403, 'This account is not linked to a library member.');

        $created = DB::transaction(function () use ($member, $book): bool {
            $lockedMember = $member->newQuery()->lockForUpdate()->findOrFail($member->id);

            if ($lockedMember->loans()->where('book_id', $book->id)->whereNull('returned_at')->exists()) {
                return false;
            }

            $lockedMember->loans()->create([
                'book_id' => $book->id,
                'borrowed_at' => now(),
            ]);

            return true;
        });

        if (! $created) {
            return back()->withErrors(['borrow' => 'You already have this book checked out.']);
        }

        return redirect()->route('my.loans')->with('status', 'Book borrowed.');
    }
}
