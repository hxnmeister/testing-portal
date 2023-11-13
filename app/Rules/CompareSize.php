<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CompareSize implements ValidationRule
{
    protected $size;

    public function __construct($size)
    {
        $this->size = $size;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if($this->size != count($value))
        {
            $fail("Not all answers was marked!");
        }
    }
}
