<x-layout title="Student Details">

    <h1>Student Details</h1>
    <p><strong>Student No.:</strong> {{ $student->student_number }}</p>
    <p><strong>Name:</strong> {{ $student->full_name }}</p>
    <p><strong>Email:</strong> {{ $student->email }}</p>
    <p><strong>Phone:</strong> {{ $student->phone ?? 'N/A' }}</p>
    <p><strong>Department:</strong> {{ $student->department->name }} | Year {{ $student->year_level }}</p>

    <h2>Enrolled Courses</h2>
    <ul>
        @forelse ($student->courses as $course)
            <li>{{ $course->code }} - {{ $course->title }} (Grade: {{ $course->pivot->grade ?? 'No grade yet' }})</li>
        @empty
            <li>No enrolled courses.</li>
        @endforelse
    </ul>

    <p>
        <a href="{{ route('students.index') }}">Back to Students</a>
        <a href="{{ route('students.edit', $student) }}">Edit</a>
    </p>

    <form method="POST" action="{{ route('students.destroy', $student) }}">
        @csrf
        @method('DELETE')
        <button type="submit">Delete</button>
    </form>
</x-layout>
