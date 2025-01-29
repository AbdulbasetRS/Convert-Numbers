<?php

namespace Abdulbaset\ConvertNumbers\Utils;

class NumberFormatter
{
    public static function convertToArabicNumerals(string $number): string
    {
        $western = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $eastern = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

        return str_replace($western, $eastern, $number);
    }

    public static function formatWithSeparators(float $number, string $decimalPoint = '.', string $thousandsSep = ','): string
    {
        return number_format($number, 2, $decimalPoint, $thousandsSep);
    }
}
