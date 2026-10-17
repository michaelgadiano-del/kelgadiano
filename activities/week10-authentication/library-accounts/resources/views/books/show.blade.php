<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">{{ $book->title }}</h2>
    </x-slot>
    <div class="mx-auto max-w-3xl space-y-4 px-4 py-8">
        @if (session('status'))
            <p class="rounded bg-green-100 px-4 py-2">{{ session('status') }}</p>
        @endif
        @if ($errors->has('borrow'))
            <p class="rounded bg-red-100 px-4 py-2">{{ $errors->first('borrow') }}</p>
        @endif
        <div class="space-y-2 rounded bg-white p-6 shadow">
            <p><b>Author:</b> {{ $book->author->name }}</p>
            <p><b>ISBN:</b> {{ $book->isbn }}</p>
            <p><b>Published:</b> {{ $book->published_year }}</p>
            <p><b>Availability:</b> {{ $book->is_reference ? 'Reference only' : 'Circulating' }}</p>
            <p><b>Currently borrowed:</b> {{ $book->active_loans_count }}</p>
            <div class="flex flex-wrap items-center gap-4 pt-4">
                @auth
                    @if (auth()->user()->role === 'member' && ! $book->is_reference)
                        <form method="POST" action="{{ route('books.borrow', $book) }}">
                            @csrf
                            <x-primary-button>Borrow</x-primary-button>
                        </form>
                    @endif
                @endauth
                @can('update', $book)
                    <a class="text-indigo-600" href="{{ route('books.edit', $book) }}">Edit</a>
                @endcan
                @can('delete', $book)
                    <form method="POST" action="{{ route('books.destroy', $book) }}">
                        @csrf
                        @method('DELETE')
                        <x-danger-button>Delete</x-danger-button>
                    </form>
                @endcan
                <a href="{{ route('books.index') }}" class="text-gray-600">Back to catalogue</a>
            </div>
        </div>
    </div>
</x-app-layout>
