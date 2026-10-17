<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">{{ $book->exists ? 'Edit book' : 'Add book' }}</h2>
    </x-slot>
    <div class="mx-auto max-w-3xl px-4 py-8">
        <form method="POST" class="space-y-4 rounded bg-white p-6 shadow"
              action="{{ $book->exists ? route('books.update', $book) : route('books.store') }}">
            @csrf
            @if ($book->exists)
                @method('PUT')
            @endif
            <div>
                <x-input-label for="title" value="Title" />
                <x-text-input id="title" name="title" class="mt-1 block w-full" :value="old('title', $book->title)" required />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="author_id" value="Author" />
                <select id="author_id" name="author_id" class="mt-1 block w-full rounded border-gray-300" required>
                    @foreach ($authors as $author)
                        <option value="{{ $author->id }}" @selected(old('author_id', $book->author_id) == $author->id)>{{ $author->name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('author_id')" class="mt-2" />
                <p class="mt-1 text-sm text-gray-500">
                    To rename an author, use the <a class="text-indigo-600" href="{{ route('authors.index') }}">Authors page</a>.
                </p>
            </div>
            <div>
                <x-input-label for="isbn" value="ISBN (13 digits)" />
                <x-text-input id="isbn" name="isbn" class="mt-1 block w-full" :value="old('isbn', $book->isbn)" required />
                <x-input-error :messages="$errors->get('isbn')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="published_year" value="Published year" />
                <x-text-input id="published_year" name="published_year" type="number" min="1000" max="{{ date('Y') }}"
                              class="mt-1 block w-full" :value="old('published_year', $book->published_year)" required />
                <x-input-error :messages="$errors->get('published_year')" class="mt-2" />
            </div>
            <div>
                <input type="hidden" name="is_reference" value="0">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="is_reference" value="1" @checked(old('is_reference', $book->is_reference))>
                    Reference book (cannot be borrowed)
                </label>
            </div>
            <div>
                <x-input-label for="cover_path" value="Cover path (optional)" />
                <x-text-input id="cover_path" name="cover_path" class="mt-1 block w-full" :value="old('cover_path', $book->cover_path)" />
                <x-input-error :messages="$errors->get('cover_path')" class="mt-2" />
            </div>
            <div class="flex items-center gap-4">
                <x-primary-button>Save book</x-primary-button>
                <a href="{{ route('books.index') }}" class="text-gray-600">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>
