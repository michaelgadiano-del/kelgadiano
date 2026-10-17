<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInstructorNameRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('renameInstructor', $this->route('user')) ?? false;
    }

    public function rules(): array
    {
        return ['name' => ['required', 'string', 'max:255']];
    }
}
