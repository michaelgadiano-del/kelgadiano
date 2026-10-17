<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800">My loans</h2></x-slot>
    <div class="mx-auto max-w-5xl space-y-4 px-4 py-8">
        @if (session('status'))
            <p class="rounded bg-green-100 px-4 py-2">{{ session('status') }}</p>
        @endif
        <div class="divide-y rounded bg-white shadow">
            @forelse ($loans as $loan)
                <div class="flex justify-between px-4 py-3">
                    <span>{{ $loan->book->title }} <small class="text-gray-500">by {{ $loan->book->author->name }}</small></span>
                    <span>{{ $loan->returned_at ? 'Returned' : 'Borrowed' }} · {{ $loan->borrowed_at->toDateString() }}</span>
                </div>
            @empty
                <p class="px-4 py-3 text-gray-500">You have no loans.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
