<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class BooleanOrNullableRule implements Rule
{
    public function passes($attribute, $value)
    {
        $value = $value == 1 ? true : false;
        // Nếu giá trị là null hoặc là boolean, rule sẽ được coi là hợp lệ.
        return $value === null || is_bool($value);
    }

    public function message()
    {
        return 'Trường :attribute phải là kiểu boolean hoặc null.';
    }
}