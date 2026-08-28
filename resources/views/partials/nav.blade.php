<nav>
    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
    <a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.*') ? 'active' : '' }}">Students</a>
    <a href="{{ route('contact.show') }}" class="{{ request()->routeIs('contact.show') ? 'active' : '' }}">Contact</a>
    <a href="{{ route('feedback.form') }}" class="{{ request()->routeIs('feedback.*') ? 'active' : '' }}">Feedback</a>
</nav>
<hr>
