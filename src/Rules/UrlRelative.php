<?php

namespace Novius\LaravelFilamentRedirectManager\Rules;

class UrlRelative extends UrlAbsoluteOrRelative
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     */
    public function passes($attribute, $value): bool
    {
        return $this->validateRelativeUrl($attribute, $value);
    }
}
