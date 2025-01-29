<?php

namespace Abdulbaset\ConvertNumbers\Languages;

use Abdulbaset\ConvertNumbers\Contracts\Abstracts\LanguageAbstract;

class EnglishLanguage extends LanguageAbstract
{

    private $units = [
        0 => 'zero',
        1 => 'one',
        2 => 'two',
        3 => 'three',
        4 => 'four',
        5 => 'five',
        6 => 'six',
        7 => 'seven',
        8 => 'eight',
        9 => 'nine',
    ];

    private $teens = [
        10 => 'ten',
        11 => 'eleven',
        12 => 'twelve',
        13 => 'thirteen',
        14 => 'fourteen',
        15 => 'fifteen',
        16 => 'sixteen',
        17 => 'seventeen',
        18 => 'eighteen',
        19 => 'nineteen',
    ];

    private $tens = [
        20 => 'twenty',
        30 => 'thirty',
        40 => 'forty',
        50 => 'fifty',
        60 => 'sixty',
        70 => 'seventy',
        80 => 'eighty',
        90 => 'ninety',
    ];

    private $scales = [
        100 => 'hundred',
        1000 => 'thousand',
        1000000 => 'million',
        1000000000 => 'billion',
    ];

    private array $fileSizeUnits = [
        'B',
        'KB',
        'MB',
        'GB',
        'TB',
        'PB'
    ];

    public function getFileSizeUnits(): array
    {
        return $this->fileSizeUnits;
    }

    public function formatFileSize(float $bytes, int $decimals = 2): string
    {
        $factor = floor((strlen((string) $bytes) - 1) / 3);
        $value = $bytes / pow(1024, $factor);
        $units = $this->getFileSizeUnits();
        
        return number_format($value, $decimals, $this->getDecimalPoint(), $this->getThousandsSeparator()) 
               . ' ' . ($units[$factor] ?? $units[0]);
    }

    protected function decimalSeparator(): string
    {
        return 'point';
    }

    public function connector(): string
    {
        return 'and';
    }

    protected function negativeSign(): string
    {
        return 'negative';
    }

    public function only(): string
    {
        return 'Only';
    }
    
    protected function language(): string
    {
        return 'en';
    }

    public function convert(int | float $number): string
    {
        if (is_float($number)) {

            $parts = explode('.', number_format($number, 2, '.', ''));
            $integerPart = (int) $parts[0];
            $decimalPart = (int) $parts[1];

            $integerString = $this->convertInteger($integerPart);

            $decimalString = $this->convertDecimal($decimalPart);

            return $integerString . ' ' . $this->decimalSeparator() . ' ' . $decimalString;
        }

        return $this->convertInteger($number);

    }

    private function convertDecimal(int $number): string
    {
        return $this->convertInteger($number);
    }

    public function convertInteger(int $number): string
    {
        if ($number < 0) {
            return $this->negativeSign() . ' ' . $this->convertInteger(abs($number));
        }

        if ($number === 0) {
            return $this->units[0];
        }

        $words = [];

        // Handle billions
        if ($number >= 1000000000) {
            $billions = (int) ($number / 1000000000);
            $words[] = $this->convertInteger($billions) . ' ' . $this->scales[1000000000];
            $number %= 1000000000;
        }

        // Handle millions
        if ($number >= 1000000) {
            $millions = (int) ($number / 1000000);
            $words[] = $this->convertInteger($millions) . ' ' . $this->scales[1000000];
            $number %= 1000000;
        }

        // Handle thousands
        if ($number >= 1000) {
            $thousands = (int) ($number / 1000);
            $words[] = $this->convertInteger($thousands) . ' ' . $this->scales[1000];
            $number %= 1000;
        }

        // Handle hundreds
        if ($number >= 100) {
            $hundreds = (int) ($number / 100);
            $words[] = $this->units[$hundreds] . ' ' . $this->scales[100];
            $number %= 100;
        }

        // Handle tens and units
        if ($number > 0) {
            if ($number < 10) {
                $words[] = $this->units[$number];
            } elseif ($number <= 19) {
                $words[] = $this->teens[$number];
            } else {
                $tens = (int) ($number / 10) * 10;
                $units = $number % 10;
                if ($units > 0) {
                    $words[] = $this->tens[$tens] . '-' . $this->units[$units];
                } else {
                    $words[] = $this->tens[$tens];
                }
            }
        }

        return implode(' ', $words);
    }

}
