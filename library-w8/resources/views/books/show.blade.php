<x-layout :title="$book->title">
    <h1>{{ $book->title }}</h1>
    <p>By {{ $book->author->name }}</p>
    <p>ISBN-13: {{ $book->isbn }} · Published {{ $book->published_year }}</p>
    <p>{{ $book->is_reference ? 'Reference only' : 'Circulating collection' }}</p>

    @if ($book->cover_path)
        <img class="book-cover" src="{{ asset('storage/'.$book->cover_path) }}" alt="Cover of {{ $book->title }}">
    @endif

    <div class="actions">
        <a href="{{ route('books.edit', $book) }}">Edit book</a>
        <a href="{{ route('books.index') }}">Back to catalogue</a>
    </div>

    <section aria-labelledby="borrow-heading">
        <h2 id="borrow-heading">Borrow this book</h2>
        @if (! $book->isAvailable())
            <p>This book is currently on loan to {{ $currentLoan?->name ?? 'a member' }}.</p>
        @endif

        @if ($errors->any())
            <div class="error-summary" role="alert">
                <strong>Please fix the {{ $errors->count() }} error(s) below.</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('books.borrow', $book) }}">
            @csrf
            <x-forms.select name="member_id" label="Member" :options="$members->pluck('name', 'id')" :selected="old('member_id')" />
            <button type="submit" @disabled(! $book->isAvailable() || $members->isEmpty())>Record loan</button>
        </form>
    </section>
</x-layout>