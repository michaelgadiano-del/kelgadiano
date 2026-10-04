<nav class="site-nav" aria-label="Main navigation">
    <div class="site-nav-inner">
        <div class="site-brand">
            <span class="site-brand-mark" aria-hidden="true">EI</span>
            <span class="site-brand-copy">
                <strong>Employee Information System</strong>
                <small>Personnel records portal</small>
            </span>
        </div>
        <div class="site-nav-links">
            @auth
                <a href="{{ route('employees.index') }}" class="{{ request()->routeIs('employees.*') ? 'active' : '' }}">Employees</a>
                <a href="{{ route('employees.create') }}">Add Employee</a>
                <form method="POST" action="{{ route('logout') }}" class="nav-logout-form">
                    @csrf
                    <button class="nav-logout" type="submit">Log out</button>
                </form>
            @else
                <a href="{{ route('login') }}">Log in</a>
                <a href="{{ route('register') }}">Register</a>
            @endauth

        </div>
    </div>
</nav>
