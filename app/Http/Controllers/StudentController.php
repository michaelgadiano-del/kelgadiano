<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(): View
    {
        $students = Student::with('department')->orderBy('last_name')->paginate(10);

        return view('students.index', compact('students'));
    }

    public function create(): View
    {
        return view('students.create', ['departments' => Department::orderBy('name')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'student_number' => ['required', 'string', 'max:20', 'unique:students'],
            'first_name' => ['required', 'string', 'max:60'],
            'last_name' => ['required', 'string', 'max:60'],
            'email' => ['required', 'email', 'unique:students'],
            'phone' => ['nullable', 'string', 'max:20'],
            'birth_date' => ['required', 'date'],
            'year_level' => ['required', 'integer', 'between:1,4'],
            'department_id' => ['required', 'exists:departments,id'],
        ]);

        Student::create($data);

        return redirect()
            ->route('students.index')
            ->with('success', 'Student added successfully.');
    }

    public function show(Student $student): View
    {
        $student->load('department', 'courses');

        return view('students.show', compact('student'));
    }

    public function edit(Student $student): View
    {
        return view('students.edit', [
            'student' => $student,
            'departments' => Department::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Student $student): RedirectResponse
    {
        $data = $request->validate([
            'student_number' => ['required', 'string', 'max:20', 'unique:students,student_number,'.$student->id],
            'first_name' => ['required', 'string', 'max:60'],
            'last_name' => ['required', 'string', 'max:60'],
            'email' => ['required', 'email', 'unique:students,email,'.$student->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'birth_date' => ['required', 'date'],
            'year_level' => ['required', 'integer', 'between:1,4'],
            'department_id' => ['required', 'exists:departments,id'],
        ]);

        $student->update($data);

        return redirect()
            ->route('students.index')
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student): RedirectResponse
    {
        $student->delete();

        return redirect()
            ->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }
}
