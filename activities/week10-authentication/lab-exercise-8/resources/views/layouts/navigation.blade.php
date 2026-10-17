<nav x-data="{ open: false }" class="border-b border-gray-100 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
            <div class="flex items-center gap-8">
                <a href="{{ route('courses.index') }}" class="font-semibold text-gray-800">WEBDEV3 — Web Framework Laravel Development</a>
                <div class="hidden items-center gap-6 sm:flex">
                    <x-nav-link :href="route('courses.index')" :active="request()->routeIs('courses.*')">Courses</x-nav-link>
                    @auth
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-nav-link>
                    @endauth
                    @can('manage-users')
                        <x-nav-link :href="route('admin.index')" :active="request()->routeIs('admin.*')">Admin</x-nav-link>
                    @endcan
                </div>
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
            <a class="block" href="{{ route('courses.index') }}">Courses</a>
            @auth
                <a class="block" href="{{ route('dashboard') }}">Dashboard</a>
                @can('manage-users')
                    <a class="block" href="{{ route('admin.index') }}">Admin</a>
                @endcan
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
