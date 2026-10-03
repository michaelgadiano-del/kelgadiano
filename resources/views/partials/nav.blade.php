<nav>
    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
    <a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.*') ? 'active' : '' }}">Students</a>
    @auth
        <a href="{{ route('employees.index') }}" class="{{ request()->routeIs('employees.*') ? 'active' : '' }}">Employees</a>
        <a href="{{ route('employees.create') }}">Add Employee</a>
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button type="submit">Log out</button>
        </form>
    @else
        <a href="{{ route('login') }}">Log in</a>
        <a href="{{ route('register') }}">Register</a>
    @endauth
    <a href="{{ route('contact.show') }}" class="{{ request()->routeIs('contact.show') ? 'active' : '' }}">Contact</a>
    <a href="{{ route('feedback.form') }}" class="{{ request()->routeIs('feedback.*') ? 'active' : '' }}">Feedback</a>
</nav>
<hr>
