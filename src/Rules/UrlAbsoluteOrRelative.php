<?php

namespace Novius\LaravelFilamentRedirectManager\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Concerns\ValidatesAttributes;

class UrlAbsoluteOrRelative implements Rule
{
    use ValidatesAttributes;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     */
    public function passes($attribute, $value): bool
    {
        return $this->validateUrl($attribute, $value) || $this->validateRelativeUrl($attribute, $value);
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return trans('laravel-filament-redirect-manager::redirect.invalid_url');
    }

    protected function validateRelativeUrl($attribute, $value): bool
    {
        if (! is_string($value)) {
            return false;
        }

        // Inspired from $this->validateUrl method
        $pattern = '~^
            (/[/\S]*|\?\S*|\#\S*) # a /, nothing, a / with something, a query or a fragment
        $~ixu';

        return preg_match($pattern, $value) > 0;
    }
}
