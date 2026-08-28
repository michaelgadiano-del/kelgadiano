<x-layout title="Student Details">
    <x-slot:aside>
        <aside>
            <h3>Student Information</h3>
            <p>ID: {{ $user->id }}</p>
            <p>Email: {{ $user->email }}</p>
        </aside>
    </x-slot:aside>

    <h1>Student Details</h1>
    <p><strong>ID:</strong> {{ $user->id }}</p>
    <p><strong>Name:</strong> {{ $user->name ?? 'Unnamed' }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>

    <x-role-badge role="Student" />

    <p>
        <a href="{{ route('students.index') }}">Back to Students</a>
        <a href="{{ route('students.edit', $user) }}">Edit</a>
    </p>

    <form method="POST" action="{{ route('students.destroy', $user) }}">
        @csrf
        @method('DELETE')
        <button type="submit">Delete</button>
    </form>
</x-layout>
