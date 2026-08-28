<x-layout title="Add Student">
    <h1>Add Student</h1>

    <form method="POST" action="{{ route('students.store') }}">
        @csrf
        <input name="name" placeholder="Name" value="{{ old('name') }}" required>
        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
        <button type="submit">Save</button>
    </form>
</x-layout>
