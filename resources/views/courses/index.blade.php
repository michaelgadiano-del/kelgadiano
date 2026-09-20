<x-layout title="Courses">
    <h1>Courses</h1>
    @if (session('success')) <p style="color: green;">{{ session('success') }}</p> @endif
    <p><a href="{{ route('courses.create') }}">Add Course</a> | <a href="{{ route('students.index') }}">Students</a></p>
    <table>
        <thead><tr><th>Code</th><th>Title</th><th>Units</th><th>Students</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse ($courses as $course)
            <tr>
                <td><a href="{{ route('courses.show', $course) }}">{{ $course->code }}</a></td>
                <td>{{ $course->title }}</td><td>{{ $course->units }}</td><td>{{ $course->students_count }}</td>
                <td><a href="{{ route('courses.edit', $course) }}">Edit</a>
                    <form method="POST" action="{{ route('courses.destroy', $course) }}" style="display:inline">
                        @csrf @method('DELETE') <button type="submit" onclick="return confirm('Delete this course?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">No courses found.</td></tr>
        @endforelse
        </tbody>
    </table>
    {{ $courses->links() }}
</x-layout>
