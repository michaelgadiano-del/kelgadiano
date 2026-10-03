<x-layout title="Courses">
    <h1>Courses</h1>
    <ul>
        @foreach ($courses as $course)
            <li>
                <a href="{{ route('courses.show', $course) }}">
                    {{ $course->code }} — {{ $course->title }}
                </a>
            </li>
        @endforeach
    </ul>
</x-layout>
