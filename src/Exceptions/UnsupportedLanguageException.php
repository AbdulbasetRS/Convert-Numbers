<?php

namespace AbdulBaset\ConvertNumbers\Exceptions;

class UnsupportedLanguageException extends \Exception
{
    public function __construct(string $language)
    {
        parent::__construct("Unsupported language: $language");
    }
}