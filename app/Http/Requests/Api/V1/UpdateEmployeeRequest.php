<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends StoreEmployeeRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        $employee = $this->route('employee');

        $rules['employee_number'] = [
            'required',
            'string',
            'max:20',
            Rule::unique('employees', 'employee_number')->ignore($employee),
        ];
        $rules['email'] = [
            'required',
            'email',
            'max:255',
            Rule::unique('employees', 'email')->ignore($employee),
        ];

        return $rules;
    }
}
