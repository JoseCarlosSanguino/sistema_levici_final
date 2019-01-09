<?php

namespace app\Http\Middleware;

class ConvertNullToEmptyStrings extends TransformsRequest
{
    /**
     * Transform the given value.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function transform($key, $value)
    {
        return is_null($value) ? '' : $value;
    }
}
