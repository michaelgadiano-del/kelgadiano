<x-layout title="Employees">
    <style>
        .employee-page {
            max-width: 1180px;
            margin: 0 auto;
            padding: 2.5rem 1.25rem;
            font-family: Arial, sans-serif;
            color: #243447;
        }

        .employee-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .employee-heading h1 {
            margin: 0 0 0.35rem;
            color: #123b5d;
            font-size: clamp(1.6rem, 3vw, 2.35rem);
        }

        .employee-heading p {
            margin: 0;
            color: #6b7b88;
        }

        .employee-add,
        .employee-action {
            display: inline-block;
            border-radius: 6px;
            padding: 0.65rem 0.9rem;
            font-size: 0.9rem;
            font-weight: 700;
            text-decoration: none;
        }

        .employee-add {
            background: #176b87;
            color: white;
            white-space: nowrap;
        }

        .employee-alert {
            margin-bottom: 1rem;
            border-left: 4px solid #258a64;
            border-radius: 4px;
            padding: 0.8rem 1rem;
            background: #e8f6ef;
            color: #17633f;
        }

        .employee-table-wrap {
            overflow-x: auto;
            border: 1px solid #d9e2e8;
            border-radius: 8px;
            background: white;
            box-shadow: 0 8px 24px rgba(25, 58, 79, 0.08);
        }

        .employee-table {
            width: 100%;
            min-width: 800px;
            border-collapse: collapse;
        }

        .employee-table th {
            padding: 0.9rem 1rem;
            background: #123b5d;
            color: white;
            font-size: 0.78rem;
            letter-spacing: 0.05em;
            text-align: left;
            text-transform: uppercase;
        }

        .employee-table td {
            padding: 1rem;
            border-bottom: 1px solid #edf1f3;
            vertical-align: middle;
        }

        .employee-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .employee-table tbody tr:hover {
            background: #f6fafc;
        }

        .employee-number {
            color: #176b87;
            font-weight: 700;
        }

        .employee-name {
            color: #123b5d;
            font-weight: 700;
            text-decoration: none;
        }

        .employee-position {
            color: #566b78;
        }

        .employee-status {
            display: inline-block;
            border-radius: 999px;
            padding: 0.35rem 0.65rem;
            background: #e8f6ef;
            color: #17633f;
            font-size: 0.78rem;
            font-weight: 700;
        }

        .employee-status--leave {
            background: #fff3d8;
            color: #8a5a00;
        }

        .employee-status--inactive {
            background: #fbe8e8;
            color: #9b3030;
        }

        .employee-actions {
            white-space: nowrap;
        }

        .employee-action {
            margin-right: 0.35rem;
            border: 1px solid #b9cbd5;
            background: white;
            color: #176b87;
        }

        .employee-delete {
            border: 0;
            background: transparent;
            color: #a13b3b;
            cursor: pointer;
            font: inherit;
            font-size: 0.9rem;
            font-weight: 700;
        }

        .employee-empty {
            padding: 2rem !important;
            color: #6b7b88;
            text-align: center;
        }

        .employee-pagination {
            margin-top: 1rem;
        }

        @media (max-width: 640px) {
            .employee-heading {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>

    <section class="employee-page">
        <div class="employee-heading">
            <div>
                <h1>Employee Information System</h1>
                <p>Manage employee records, departments, positions, and status.</p>
            </div>
            <a class="employee-add" href="{{ route('employees.create') }}">+ Add Employee</a>
        </div>

        @if (session('success'))
            <div class="employee-alert">{{ session('success') }}</div>
        @endif

        <div class="employee-table-wrap">
            <table class="employee-table">
                <thead>
                    <tr><th>Employee No.</th><th>Employee Name</th><th>Position</th><th>Department</th><th>Status</th><th>Actions</th></tr>
                </thead>
                <tbody>
                @forelse ($employees as $employee)
                    <tr>
                        <td class="employee-number">{{ $employee->employee_number }}</td>
                        <td><a class="employee-name" href="{{ route('employees.show', $employee) }}">{{ $employee->full_name }}</a></td>
                        <td class="employee-position">{{ $employee->position }}</td>
                        <td>{{ $employee->department->name }}</td>
                        <td><span class="employee-status employee-status--{{ strtolower(str_replace(' ', '-', $employee->status)) }}">{{ $employee->status }}</span></td>
                        <td class="employee-actions">
                            <a class="employee-action" href="{{ route('employees.edit', $employee) }}">Edit</a>
                            <form method="POST" action="{{ route('employees.destroy', $employee) }}" style="display:inline" onsubmit="return confirm('Delete this employee?')">
                                @csrf
                                @method('DELETE')
                                <button class="employee-delete" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td class="employee-empty" colspan="6">No employees found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="employee-pagination">{{ $employees->links() }}</div>
    </section>
</x-layout>
