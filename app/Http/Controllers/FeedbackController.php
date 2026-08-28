<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    public function create(): View
    {
        return view('feedback');
    }

    public function store(FeedbackRequest $request): RedirectResponse
    {
        return redirect()
            ->route('feedback.form')
            ->with('success', 'Feedback received successfully.');
    }

    public function destroy(string $id): RedirectResponse
    {
        return redirect()
            ->route('feedback.form')
            ->with('success', "Feedback {$id} deleted successfully.");
    }
}