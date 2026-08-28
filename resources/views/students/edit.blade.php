<x-layout title="Edit Student">
    <h1>Edit Student</h1>

    <form method="POST" action="{{ route('students.update', $user) }}">
        @csrf
        @method('PUT')
        <input name="name" value="{{ old('name', $user->name) }}" required>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
        <button type="submit">Update</button>
    </form>
</x-layout>
