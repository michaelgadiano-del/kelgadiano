<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Support\Facades\Gate;

class LoanController extends Controller
{
    public function myLoans()
    {
        Gate::authorize('viewAny', Loan::class);
        $member = request()->user()->member;

        abort_unless($member, 403, 'This account is not linked to a library member.');

        $loans = $member->loans()->with('book.author')->latest('borrowed_at')->get();
        $loans->each(fn (Loan $loan) => Gate::authorize('view', $loan));

        return view('loans.index', compact('loans'));
    }

    public function desk()
    {
        Gate::authorize('viewAny', Loan::class);
        $loans = Loan::with(['book', 'member'])->latest('borrowed_at')->get();

        return view('loans.desk', compact('loans'));
    }

    public function markReturned(Loan $loan)
    {
        Gate::authorize('markReturned', $loan);

        if ($loan->returned_at === null) {
            $loan->update(['returned_at' => now()]);
        }

        return back()->with('status', 'Loan marked as returned.');
    }
}
