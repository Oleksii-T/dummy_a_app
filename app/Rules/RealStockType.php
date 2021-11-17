<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Services\YahooFinanceParser;

class RealStockType implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            YahooFinanceParser::getTable($value);
        } catch (\Throwable $th) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "Unavailable stock type.";
    }
}
