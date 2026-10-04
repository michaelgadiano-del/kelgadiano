<x-layout title="Employees">
    <section class="record-page employee-list-page">
        <header class="page-heading">
            <div>
                <h1>Employee Information System</h1>
                <p>Manage employee records, departments, positions, and status.</p>
            </div>
            <div class="page-heading-actions employee-list-actions">
                <form class="employee-search-form" method="GET" action="{{ route('employees.index') }}">
                    <label class="visually-hidden" for="employee-search">Search employees</label>
                    <input
                        id="employee-search"
                        name="search"
                        type="search"
                        value="{{ $search }}"
                        placeholder="Search employees..."
                    >
                    <button class="button button-secondary" type="submit">Search</button>
                </form>
                <a class="button button-primary" href="{{ route('employees.create') }}">Add Employee</a>
            </div>
        </header>

        @if (session('success'))
            <p class="success page-notice">{{ session('success') }}</p>
        @endif

        <div class="table-card">
            <div class="table-scroll">
                <table class="records-table">
                    <thead>
                        <tr>
                            <th>Employee No.</th>
                            <th>Employee Name</th>
                            <th>Position</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($employees as $employee)
                        <tr>
                            <td class="record-id">{{ $employee->employee_number }}</td>
                            <td><a class="record-name" href="{{ route('employees.show', $employee) }}">{{ $employee->full_name }}</a></td>
                            <td>{{ $employee->position }}</td>
                            <td>{{ $employee->department->name }}</td>
                            <td><span class="employee-status employee-status--{{ strtolower(str_replace(' ', '-', $employee->status)) }}">{{ $employee->status }}</span></td>
                            <td class="record-actions">
                                <a class="table-action" href="{{ route('employees.edit', $employee) }}">Edit</a>
                                <form method="POST" action="{{ route('employees.destroy', $employee) }}" class="inline-form" onsubmit="return confirm('Delete this employee?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="table-action table-action-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td class="empty-state" colspan="6">No employees found.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="record-pagination">{{ $employees->links() }}</div>
    </section>
</x-layout>
