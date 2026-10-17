<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Manage Users and Instructor Names</h2>
    </x-slot>
    <div class="mx-auto max-w-5xl px-4 py-8">
        @if (session('status'))
            <p class="mb-4 rounded bg-green-100 px-4 py-2">{{ session('status') }}</p>
        @endif
        @if ($errors->any())
            <p class="mb-4 rounded bg-red-100 px-4 py-2">{{ $errors->first() }}</p>
        @endif
        <table class="w-full rounded bg-white text-left shadow">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Role</th>
                    <th class="px-4 py-2">Courses owned</th>
                    <th class="px-4 py-2">Update instructor name</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach ($users as $user)
                    <tr>
                        <td class="px-4 py-2">{{ $user->name }}</td>
                        <td class="px-4 py-2">{{ $user->email }}</td>
                        <td class="px-4 py-2">{{ $user->role }}</td>
                        <td class="px-4 py-2">{{ $user->courses_count }}</td>
                        <td class="px-4 py-2">
                            @if ($user->role === 'instructor')
                                <form method="POST" action="{{ route('admin.users.name', $user) }}" class="flex gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <input name="name" value="{{ $user->name }}" maxlength="255" required
                                           class="min-w-0 rounded border-gray-300 text-sm">
                                    <button class="text-indigo-600">Save</button>
                                </form>
                            @else
                                <span class="text-sm text-gray-400">Instructor accounts only</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
