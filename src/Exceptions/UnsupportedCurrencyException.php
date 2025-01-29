<?php

namespace AbdulBaset\ConvertNumbers\Exceptions;

class UnsupportedCurrencyException extends \Exception
{
    public function __construct(string $currency)
    {
        parent::__construct("Unsupported currency: $currency");
    }
}