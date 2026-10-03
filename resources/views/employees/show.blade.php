<x-layout title="Employee Details">
    <h1>{{ $employee->full_name }}</h1>
    <p><strong>Employee Number:</strong> {{ $employee->employee_number }}</p>
    <p><strong>Email:</strong> {{ $employee->email }}</p>
    <p><strong>Phone:</strong> {{ $employee->phone ?: 'N/A' }}</p>
    <p><strong>Position:</strong> {{ $employee->position }}</p>
    <p><strong>Department:</strong> {{ $employee->department->name }}</p>
    <p><strong>Hire Date:</strong> {{ $employee->hire_date->format('F d, Y') }}</p>
    <p><strong>Monthly Salary:</strong> {{ number_format((float) $employee->salary, 2) }}</p>
    <p><strong>Status:</strong> {{ $employee->status }}</p>

    <a href="{{ route('employees.edit', $employee) }}">Edit</a>
    <a href="{{ route('employees.index') }}">Back to Employees</a>
</x-layout>
