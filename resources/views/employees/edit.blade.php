<x-layout title="Edit Employee">
    <h1>Edit Employee</h1>

    <form method="POST" action="{{ route('employees.update', $employee) }}">
        @csrf
        @method('PUT')
        @include('employees._form')
        <button type="submit">Update Employee</button>
        <a href="{{ route('employees.index') }}">Cancel</a>
    </form>
</x-layout>
