<?php

namespace Abdulbaset\ConvertNumbers\Contracts\Interfaces;

interface ConverterInterface
{
    public function convert(int|float $number): string;
}