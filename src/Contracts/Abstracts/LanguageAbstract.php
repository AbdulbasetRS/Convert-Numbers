<?php

namespace Abdulbaset\ConvertNumbers\Contracts\Abstracts;

use Abdulbaset\ConvertNumbers\Contracts\Interfaces\ConverterInterface;

abstract class LanguageAbstract implements ConverterInterface
{
    abstract protected function language(): string;
    abstract protected function decimalSeparator(): string;
    abstract protected function connector(): string;
    abstract protected function negativeSign(): string;
    abstract public function only(): string;
    abstract public function convert(int | float $number): string;

    public function getDecimalPoint(): string
    {
        return $this->language() === 'ar' ? '٫' : '.';
    }

    public function getThousandsSeparator(): string
    {
        return $this->language() === 'ar' ? '٬' : ',';
    }
}