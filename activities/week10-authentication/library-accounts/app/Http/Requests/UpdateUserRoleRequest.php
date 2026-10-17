<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        $newRole = $this->input('role');

        return is_string($newRole)
            && ($this->user()?->can('changeRole', [$this->route('user'), $newRole]) ?? false);
    }

    public function rules(): array
    {
        return ['role' => ['required', 'in:member,librarian,admin']];
    }
}
