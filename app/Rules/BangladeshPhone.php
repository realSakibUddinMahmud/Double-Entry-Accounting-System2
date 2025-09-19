<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class BangladeshPhone implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        // Remove any spaces, hyphens, or other formatting
        $cleanPhone = preg_replace('/[^\+\d]/', '', $value);
        
        // Check international format (+8801XXXXXXXXX - 14 characters)
        if (substr($cleanPhone, 0, 4) === '+880') {
            if (strlen($cleanPhone) !== 14) {
                return false;
            }
            // For international format, we need to reconstruct the operator prefix
            // +8801712345678 becomes 01712345678 locally
            // So we add '0' to the first 2 digits after +880
            $operatorPrefix = '0' . substr($cleanPhone, 4, 2);
        }
        // Check local format (01XXXXXXXXX - 11 digits)
        elseif (substr($cleanPhone, 0, 2) === '01') {
            if (strlen($cleanPhone) !== 11) {
                return false;
            }
            // Extract the operator prefix (characters 0-2, like 017...)
            $operatorPrefix = substr($cleanPhone, 0, 3);
        }
        else {
            return false;
        }
        
        // Valid Bangladesh operator prefixes
        $validPrefixes = ['013', '014', '015', '016', '017', '018', '019'];
        
        return in_array($operatorPrefix, $validPrefixes);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid Bangladesh phone number. Valid formats: 01XXXXXXXXX (11 digits) or +8801XXXXXXXXX (14 characters) with operator prefixes 013, 014, 015, 016, 017, 018, 019.';
    }
}