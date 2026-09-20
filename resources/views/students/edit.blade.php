<x-layout title="Edit Student">
    <h1>Edit Student</h1>

    <form method="POST" action="{{ route('students.update', $student) }}">
        @csrf
        @method('PUT')
        @include('students._form')
        <button type="submit">Update</button>
    </form>
</x-layout>
