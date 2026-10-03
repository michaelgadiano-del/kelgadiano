<?php

namespace App\Http\Controllers;

use App\Http\Requests\BorrowBookRequest;
use App\Models\Book;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BorrowBookController extends Controller
{
    public function store(BorrowBookRequest $request, Book $book): RedirectResponse
    {
        $memberId = $request->validated('member_id');

        DB::transaction(function () use ($book, $memberId): void {
            $lockedBook = Book::query()->lockForUpdate()->findOrFail($book->id);
            $member = Member::query()->lockForUpdate()->findOrFail($memberId);

            if (! $lockedBook->isAvailable()) {
                throw ValidationException::withMessages([
                    'member_id' => 'This book is currently on loan.',
                ]);
            }

            if ($member->books()->wherePivotNull('returned_at')->count() >= 3) {
                throw ValidationException::withMessages([
                    'member_id' => 'A member may have no more than 3 unreturned loans.',
                ]);
            }

            $lockedBook->members()->attach($member->id, [
                'borrowed_at' => now(),
                'returned_at' => null,
            ]);
        });

        return redirect()->route('books.show', $book)->with('status', 'Book borrowed successfully.');
    }
}
