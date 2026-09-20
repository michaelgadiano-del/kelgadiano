<x-layout title="Add Student">
    <h1>Add Student</h1>

    <form method="POST" action="{{ route('students.store') }}">
        @csrf
        @include('students._form')
        <button type="submit">Save</button>
    </form>
</x-layout>
