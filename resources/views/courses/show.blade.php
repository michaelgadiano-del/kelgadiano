<x-layout title="Course Details">
    <h1>{{ $course->code }} - {{ $course->title }}</h1>
    <p>Units: {{ $course->units }}</p>
    <h2>Enrolled Students</h2>
    <table>
        <thead><tr><th>Student Number</th><th>Name</th><th>Grade</th></tr></thead>
        <tbody>
        @forelse ($course->students as $student)
            <tr><td>{{ $student->student_number }}</td><td>{{ $student->full_name }}</td><td>{{ $student->pivot->grade ?? 'No grade yet' }}</td></tr>
        @empty
            <tr><td colspan="3">No enrolled students.</td></tr>
        @endforelse
        </tbody>
    </table>
    <p><a href="{{ route('courses.index') }}">Back to Courses</a> | <a href="{{ route('courses.edit', $course) }}">Edit</a></p>
</x-layout>
