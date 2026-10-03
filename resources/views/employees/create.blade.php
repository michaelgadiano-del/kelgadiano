<x-layout title="Add Employee">
    <h1>Add Employee</h1>

    <form method="POST" action="{{ route('employees.store') }}">
        @csrf
        @include('employees._form')
        <button type="submit">Save Employee</button>
        <a href="{{ route('employees.index') }}">Cancel</a>
    </form>
</x-layout>
