@if ($errors->any())
    <div>
        <strong>Please fix the following:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<label for="employee_number">Employee Number</label>
<input id="employee_number" name="employee_number" value="{{ old('employee_number', $employee->employee_number ?? '') }}" required>

<label for="first_name">First Name</label>
<input id="first_name" name="first_name" value="{{ old('first_name', $employee->first_name ?? '') }}" required>

<label for="last_name">Last Name</label>
<input id="last_name" name="last_name" value="{{ old('last_name', $employee->last_name ?? '') }}" required>

<label for="email">Email</label>
<input id="email" type="email" name="email" value="{{ old('email', $employee->email ?? '') }}" required>

<label for="phone">Phone</label>
<input id="phone" name="phone" value="{{ old('phone', $employee->phone ?? '') }}">

<label for="position">Position</label>
<input id="position" name="position" value="{{ old('position', $employee->position ?? '') }}" required>

<label for="hire_date">Hire Date</label>
<input id="hire_date" type="date" name="hire_date" value="{{ old('hire_date', isset($employee) ? $employee->hire_date->format('Y-m-d') : '') }}" required>

<label for="salary">Monthly Salary</label>
<input id="salary" type="number" step="0.01" min="0" name="salary" value="{{ old('salary', $employee->salary ?? '') }}" required>

<label for="status">Status</label>
<select id="status" name="status" required>
    @foreach (['Active', 'On Leave', 'Inactive'] as $status)
        <option value="{{ $status }}" @selected(old('status', $employee->status ?? 'Active') === $status)>{{ $status }}</option>
    @endforeach
</select>

<label for="department_id">Department</label>
<select id="department_id" name="department_id" required>
    <option value="">Select department</option>
    @foreach ($departments as $department)
        <option value="{{ $department->id }}" @selected((string) old('department_id', $employee->department_id ?? '') === (string) $department->id)>{{ $department->name }}</option>
    @endforeach
</select>
