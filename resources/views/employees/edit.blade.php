<x-layout title="Edit Employee">
    <section class="record-page record-form-page">
        <header class="page-heading page-heading-centered">
            <h1>Edit Employee</h1>
            <p>Update the employee information below.</p>
        </header>

        <form class="record-form-card" method="POST" action="{{ route('employees.update', $employee) }}">
            @csrf
            @method('PUT')
            @include('employees._form')
            <div class="form-actions form-actions-stacked">
                <button class="button button-primary" type="submit">Update Employee</button>
                <a class="button button-secondary" href="{{ route('employees.index') }}">Back to Employees</a>
            </div>
        </form>
    </section>
</x-layout>
