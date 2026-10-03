<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class IsbnChecksum implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || ! preg_match('/^\d{13}$/', $value)) {
            $fail('The :attribute must contain exactly 13 digits.');

            return;
        }

        $sum = 0;

        for ($index = 0; $index < 12; $index++) {
            $sum += (int) $value[$index] * ($index % 2 === 0 ? 1 : 3);
        }

        $checkDigit = (10 - ($sum % 10)) % 10;

        if ($checkDigit !== (int) $value[12]) {
            $fail('The :attribute has an invalid ISBN-13 check digit.');
        }
    }
}
