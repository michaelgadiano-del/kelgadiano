<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800">Admin — users and roles</h2></x-slot>
    <div class="mx-auto max-w-6xl space-y-4 px-4 py-8">
        @if (session('status'))
            <p class="rounded bg-green-100 px-4 py-2">{{ session('status') }}</p>
        @endif
        @if ($errors->any())
            <p class="rounded bg-red-100 px-4 py-2">{{ $errors->first() }}</p>
        @endif
        <div class="overflow-x-auto rounded bg-white shadow">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr><th class="px-4 py-2">Name</th><th class="px-4 py-2">Email</th><th class="px-4 py-2">Role</th><th class="px-4 py-2">Change role</th></tr>
                </thead>
                <tbody class="divide-y">
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-4 py-2">{{ $user->name }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2">{{ $user->role }}</td>
                            <td class="px-4 py-2">
                                <form class="flex items-center gap-2" method="POST" action="{{ route('admin.users.role', $user) }}">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" class="rounded border-gray-300 text-sm">
                                        @foreach (['member', 'librarian', 'admin'] as $role)
                                            @if ($user->id !== auth()->id() || $role === 'admin')
                                                <option value="{{ $role }}" @selected($user->role === $role)>{{ ucfirst($role) }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <button class="text-indigo-600">Save</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <p class="text-sm text-gray-600">An admin cannot change their own role to a non-admin role.</p>
    </div>
</x-app-layout>
