<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
        ]);
        $search = trim($validated['search'] ?? '');

        $employees = Employee::with('department')
            ->when($search !== '', function ($query) use ($search): void {
                foreach (preg_split('/\s+/', $search) as $term) {
                    $query->where(function ($query) use ($term): void {
                        $pattern = "%{$term}%";
                        $query->where('employee_number', 'like', $pattern)
                            ->orWhere('first_name', 'like', $pattern)
                            ->orWhere('last_name', 'like', $pattern)
                            ->orWhere('email', 'like', $pattern)
                            ->orWhere('phone', 'like', $pattern)
                            ->orWhere('position', 'like', $pattern)
                            ->orWhere('status', 'like', $pattern)
                            ->orWhereHas('department', function ($query) use ($pattern): void {
                                $query->where('name', 'like', $pattern);
                            });
                    });
                }
            })
            ->orderBy('last_name')
            ->paginate(10)
            ->withQueryString();

        return view('employees.index', compact('employees', 'search'));
    }

    public function create(): View
    {
        return view('employees.create', [
            'departments' => Department::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Employee::create($this->validatedData($request));

        return redirect()->route('employees.index')->with('success', 'Employee added successfully.');
    }

    public function show(Employee $employee): View
    {
        $employee->load('department');

        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee): View
    {
        return view('employees.edit', [
            'employee' => $employee,
            'departments' => Department::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Employee $employee): RedirectResponse
    {
        $employee->update($this->validatedData($request, $employee));

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee): RedirectResponse
    {
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }

    private function validatedData(Request $request, ?Employee $employee = null): array
    {
        $employeeNumberRule = 'unique:employees,employee_number'.($employee ? ','.$employee->id : '');
        $emailRule = 'unique:employees,email'.($employee ? ','.$employee->id : '');

        return $request->validate([
            'employee_number' => ['required', 'string', 'max:20', $employeeNumberRule],
            'first_name' => ['required', 'string', 'max:60'],
            'last_name' => ['required', 'string', 'max:60'],
            'email' => ['required', 'email', $emailRule],
            'phone' => ['nullable', 'string', 'max:20'],
            'position' => ['required', 'string', 'max:80'],
            'hire_date' => ['required', 'date'],
            'salary' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'status' => ['required', 'in:Active,On Leave,Inactive'],
            'department_id' => ['required', 'exists:departments,id'],
        ]);
    }
}
