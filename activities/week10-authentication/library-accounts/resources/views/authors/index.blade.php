<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Manage Author Names</h2>
    </x-slot>
    <div class="mx-auto max-w-5xl space-y-4 px-4 py-8">
        @if (session('status'))
            <p class="rounded bg-green-100 px-4 py-2">{{ session('status') }}</p>
        @endif
        @if ($errors->any())
            <p class="rounded bg-red-100 px-4 py-2">{{ $errors->first() }}</p>
        @endif
        <p class="text-sm text-gray-600">Edit generated demo names here. Updated names will appear beside their books.</p>
        <div class="divide-y rounded bg-white shadow">
            @foreach ($authors as $author)
                <form method="POST" action="{{ route('authors.update', $author) }}"
                      class="flex flex-wrap items-center gap-3 px-4 py-3">
                    @csrf
                    @method('PATCH')
                    <span class="min-w-24 text-sm text-gray-500">{{ $author->books_count }} books</span>
                    <input name="name" value="{{ $author->name }}" maxlength="255" required
                           class="min-w-0 flex-1 rounded border-gray-300">
                    <x-primary-button>Save</x-primary-button>
                </form>
            @endforeach
        </div>
        <a href="{{ route('books.index') }}" class="text-indigo-600">Back to books</a>
    </div>
</x-app-layout>
