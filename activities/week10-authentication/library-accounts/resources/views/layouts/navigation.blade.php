<nav x-data="{ open: false }" class="border-b border-gray-100 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center gap-8">
                <a href="{{ route('books.index') }}" class="font-semibold text-gray-800">Library Accounts and Staff</a>
                <a href="{{ route('books.index') }}" class="hidden text-sm text-gray-700 sm:block">Books</a>
                @auth
                    @if (auth()->user()->role === 'member')
                        <a href="{{ route('my.loans') }}" class="hidden text-sm text-gray-700 sm:block">My loans</a>
                    @endif
                    @if (in_array(auth()->user()->role, ['librarian', 'admin'], true))
                        <a href="{{ route('desk') }}" class="hidden text-sm text-gray-700 sm:block">Desk</a>
                        <a href="{{ route('authors.index') }}" class="hidden text-sm text-gray-700 sm:block">Authors</a>
                    @endif
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('admin.users.index') }}" class="hidden text-sm text-gray-700 sm:block">Users</a>
                    @endif
                @endauth
            </div>
            <div class="hidden items-center gap-4 sm:flex">
                @auth
                    <span class="text-sm text-gray-600">{{ auth()->user()->name }} ({{ auth()->user()->role }})</span>
                    <a href="{{ route('profile.edit') }}" class="text-sm text-gray-700">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-sm text-gray-700">Log out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700">Log in</a>
                    <a href="{{ route('register') }}" class="text-sm text-gray-700">Register</a>
                @endauth
            </div>
            <button @click="open = ! open" class="sm:hidden" aria-label="Toggle navigation">Menu</button>
        </div>
        <div x-show="open" class="space-y-2 border-t py-3 sm:hidden">
            <a class="block" href="{{ route('books.index') }}">Books</a>
            @auth
                @if (auth()->user()->role === 'member')
                    <a class="block" href="{{ route('my.loans') }}">My loans</a>
                @endif
                @if (in_array(auth()->user()->role, ['librarian', 'admin'], true))
                    <a class="block" href="{{ route('desk') }}">Desk</a>
                    <a class="block" href="{{ route('authors.index') }}">Authors</a>
                @endif
                @if (auth()->user()->role === 'admin')
                    <a class="block" href="{{ route('admin.users.index') }}">Users</a>
                @endif
                <a class="block" href="{{ route('profile.edit') }}">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button>Log out</button>
                </form>
            @else
                <a class="block" href="{{ route('login') }}">Log in</a>
                <a class="block" href="{{ route('register') }}">Register</a>
            @endauth
        </div>
    </div>
</nav>
