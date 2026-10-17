<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">Library catalogue</h2>
            @can('create', App\Models\Book::class)
                <a class="text-indigo-600" href="{{ route('books.create') }}">Add book</a>
            @endcan
        </div>
    </x-slot>
    <div class="mx-auto max-w-5xl space-y-4 px-4 py-8">
        @if (session('status'))
            <p class="rounded bg-green-100 px-4 py-2">{{ session('status') }}</p>
        @endif
        <div class="divide-y rounded bg-white shadow">
            @forelse ($books as $book)
                <a class="block px-4 py-3 hover:bg-gray-50" href="{{ route('books.show', $book) }}">
                    <b>{{ $book->title }}</b>
                    <span class="text-sm text-gray-600">— {{ $book->author->name }}</span>
                    @if ($book->is_reference)
                        <span class="ml-2 text-xs text-amber-700">Reference only</span>
                    @endif
                </a>
            @empty
                <p class="px-4 py-3 text-gray-500">No books yet.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
