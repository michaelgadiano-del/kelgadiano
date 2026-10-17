<?php

namespace App\Http\Requests;

use App\Models\Book;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookRequest extends FormRequest
{
    public function authorize(): bool
    {
        $book = $this->route('book');

        return $this->user()?->can($book ? 'update' : 'create', $book ?? Book::class) ?? false;
    }

    public function rules(): array
    {
        $book = $this->route('book');

        return [
            'author_id' => ['required', 'integer', 'exists:authors,id'],
            'isbn' => [
                'required',
                'string',
                'size:13',
                Rule::unique('books', 'isbn')->ignore($book),
            ],
            'title' => ['required', 'string', 'max:255'],
            'published_year' => ['required', 'integer', 'between:1000,'.date('Y')],
            'is_reference' => ['required', 'boolean'],
            'cover_path' => ['nullable', 'string', 'max:255'],
        ];
    }
}
