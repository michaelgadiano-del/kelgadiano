<?php

namespace App\Http\Requests;

use App\Rules\IsbnChecksum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookRequest extends FormRequest
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
            'isbn' => ['required', 'string', 'size:13', new IsbnChecksum, Rule::unique('books', 'isbn')],
            'title' => ['required', 'string', 'max:255'],
            'author_id' => ['required', 'integer', 'exists:authors,id'],
            'published_year' => ['required', 'integer', 'between:1450,'.now()->year],
            'is_reference' => ['boolean'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
        ];
    }

    public function messages(): array
    {
        return [
            'isbn.unique' => 'That ISBN is already registered.',
            'cover.mimes' => 'The cover must be a JPG or PNG image.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'isbn' => str_replace('-', '', trim((string) $this->input('isbn', ''))),
            'is_reference' => $this->boolean('is_reference'),
        ]);
    }
}
