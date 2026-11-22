<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'employee_number' => ['required', 'string', 'max:20', Rule::unique('employees', 'employee_number')],
            'first_name' => ['required', 'string', 'max:60'],
            'last_name' => ['required', 'string', 'max:60'],
            'email' => ['required', 'email', 'max:255', Rule::unique('employees', 'email')],
            'phone' => ['nullable', 'string', 'max:20'],
            'position' => ['required', 'string', 'max:80'],
            'hire_date' => ['required', 'date'],
            'salary' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'status' => ['required', Rule::in(['Active', 'On Leave', 'Inactive'])],
            'department_id' => ['required', 'integer', Rule::exists('departments', 'id')],
        ];
    }
}
