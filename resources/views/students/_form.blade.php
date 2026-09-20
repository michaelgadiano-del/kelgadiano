@if ($errors->any())
    <ul style="color: red;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<label>Student Number <input name="student_number" value="{{ old('student_number', $student->student_number ?? '') }}" required></label><br>
<label>First Name <input name="first_name" value="{{ old('first_name', $student->first_name ?? '') }}" required></label><br>
<label>Last Name <input name="last_name" value="{{ old('last_name', $student->last_name ?? '') }}" required></label><br>
<label>Email <input type="email" name="email" value="{{ old('email', $student->email ?? '') }}" required></label><br>
<label>Phone <input name="phone" value="{{ old('phone', $student->phone ?? '') }}"></label><br>
<label>Birth Date <input type="date" name="birth_date" value="{{ old('birth_date', isset($student) ? $student->birth_date->format('Y-m-d') : '') }}" required></label><br>
<label>Year Level
    <select name="year_level">
        @foreach ([1, 2, 3, 4] as $year)
            <option value="{{ $year }}" @selected(old('year_level', $student->year_level ?? 1) == $year)>{{ $year }}</option>
        @endforeach
    </select>
</label><br>
<label>Department
    <select name="department_id" required>
        @foreach ($departments as $department)
            <option value="{{ $department->id }}" @selected(old('department_id', $student->department_id ?? '') == $department->id)>{{ $department->name }}</option>
        @endforeach
    </select>
</label><br>
