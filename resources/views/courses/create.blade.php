<x-layout title="Add Course">
    <h1>Add Course</h1>
    <form method="POST" action="{{ route('courses.store') }}">
        @csrf
        @include('courses._form')
        <button type="submit">Save</button>
    </form>
</x-layout>
