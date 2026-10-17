<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800">Library desk — loans</h2></x-slot>
    <div class="mx-auto max-w-6xl px-4 py-8">
        @if (session('status'))
            <p class="mb-4 rounded bg-green-100 px-4 py-2">{{ session('status') }}</p>
        @endif
        <div class="overflow-x-auto rounded bg-white shadow">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr><th class="px-4 py-2">Book</th><th class="px-4 py-2">Member</th><th class="px-4 py-2">Borrowed</th><th class="px-4 py-2">Returned</th><th class="px-4 py-2">Action</th></tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($loans as $loan)
                        <tr>
                            <td class="px-4 py-2">{{ $loan->book->title }}</td>
                            <td class="px-4 py-2">{{ $loan->member->name }}</td>
                            <td class="px-4 py-2">{{ $loan->borrowed_at->toDateString() }}</td>
                            <td class="px-4 py-2">{{ $loan->returned_at?->toDateString() ?? 'Not returned' }}</td>
                            <td class="px-4 py-2">
                                @if (! $loan->returned_at)
                                    <form method="POST" action="{{ route('desk.loans.return', $loan) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="text-indigo-600">Mark returned</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-3 text-gray-500">No loans yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
