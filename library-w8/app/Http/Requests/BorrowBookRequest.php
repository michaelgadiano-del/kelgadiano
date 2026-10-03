<?php

namespace App\Http\Requests;

use App\Models\Book;
use App\Models\Member;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class BorrowBookRequest extends FormRequest
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
            'member_id' => ['required', 'integer', 'exists:members,id'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            $book = $this->route('book');
            $member = Member::find($this->input('member_id'));

            if (! $book instanceof Book || ! $member) {
                return;
            }

            if (! $book->isAvailable()) {
                $validator->errors()->add('member_id', 'This book is currently on loan.');
            }

            if ($member->books()->wherePivotNull('returned_at')->count() >= 3) {
                $validator->errors()->add('member_id', 'A member may have no more than 3 unreturned loans.');
            }
        });
    }
}
