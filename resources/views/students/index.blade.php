<x-layout title="Students">
    <h1>Students</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <a href="{{ route('students.create') }}">Add Student</a>

    <ul>
        @forelse ($students as $student)
            <li>
                <x-student-card :student="$student" />
            </li>
        @empty
            <li>No students found.</li>
        @endforelse
    </ul>
</x-layout>
