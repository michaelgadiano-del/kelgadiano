<?php

namespace App\Http\Requests;

use App\Rules\IsbnChecksum;
use Illuminate\Validation\Rule;

class UpdateBookRequest extends StoreBookRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['isbn'] = [
            'required',
            'string',
            'size:13',
            new IsbnChecksum,
            Rule::unique('books', 'isbn')->ignore($this->route('book')),
        ];

        return $rules;
    }
}
