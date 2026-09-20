<x-layout title="Students">
    <h1>Students</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <p><a href="{{ route('students.create') }}">Add Student</a> | <a href="{{ route('courses.index') }}">Courses</a></p>

    <table>
        <thead><tr><th>Student No.</th><th>Name</th><th>Email</th><th>Phone</th><th>Department</th><th>Year</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse ($students as $student)
            <tr>
                <td>{{ $student->student_number }}</td>
                <td><a href="{{ route('students.show', $student) }}">{{ $student->full_name }}</a></td>
                <td>{{ $student->email }}</td>
                <td>{{ $student->phone ?? 'N/A' }}</td>
                <td>{{ $student->department->code }}</td>
                <td>{{ $student->year_level }}</td>
                <td><a href="{{ route('students.edit', $student) }}">Edit</a>
                    <form method="POST" action="{{ route('students.destroy', $student) }}" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this student?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7">No students found.</td></tr>
        @endforelse
        </tbody>
    </table>
    {{ $students->links() }}
</x-layout>
