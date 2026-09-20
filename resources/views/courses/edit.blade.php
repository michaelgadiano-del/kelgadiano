<x-layout title="Edit Course">
    <h1>Edit Course</h1>
    <form method="POST" action="{{ route('courses.update', $course) }}">
        @csrf @method('PUT')
        @include('courses._form')
        <button type="submit">Update</button>
    </form>
</x-layout>
