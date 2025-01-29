<?php

namespace Abdulbaset\ConvertNumbers\Languages;

use Abdulbaset\ConvertNumbers\Contracts\Abstracts\LanguageAbstract;

class FrenchLanguage extends LanguageAbstract
{
    private $units = [
        0 => 'zéro',
        1 => 'un',
        2 => 'deux',
        3 => 'trois',
        4 => 'quatre',
        5 => 'cinq',
        6 => 'six',
        7 => 'sept',
        8 => 'huit',
        9 => 'neuf',
    ];

    private $teens = [
        10 => 'dix',
        11 => 'onze',
        12 => 'douze',
        13 => 'treize',
        14 => 'quatorze',
        15 => 'quinze',
        16 => 'seize',
        17 => 'dix-sept',
        18 => 'dix-huit',
        19 => 'dix-neuf',
    ];

    private $tens = [
        20 => 'vingt',
        30 => 'trente',
        40 => 'quarante',
        50 => 'cinquante',
        60 => 'soixante',
        70 => 'soixante-dix',
        80 => 'quatre-vingt',
        90 => 'quatre-vingt-dix',
    ];

    private $scales = [
        100 => 'cent',
        1000 => 'mille',
        1000000 => 'million',
        1000000000 => 'milliard',
    ];

    private array $fileSizeUnits = [
        'o',
        'Ko',
        'Mo',
        'Go',
        'To',
        'Po'
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
        return 'virgule';
    }

    public function connector(): string
    {
        return 'et';
    }

    protected function negativeSign(): string
    {
        return 'négatif';
    }

    public function only(): string
    {
        return 'Uniquement';
    }
    
    protected function language(): string
    {
        return 'fr';
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
            $billions = (int)($number / 1000000000);
            if ($billions === 1) {
                $words[] = $this->units[1] . ' ' . $this->scales[1000000000];
            } else {
                $words[] = $this->convertInteger($billions) . ' ' . $this->scales[1000000000] . 's';
            }
            $number %= 1000000000;
        }

        // Handle millions
        if ($number >= 1000000) {
            $millions = (int)($number / 1000000);
            if ($millions === 1) {
                $words[] = $this->units[1] . ' ' . $this->scales[1000000];
            } else {
                $words[] = $this->convertInteger($millions) . ' ' . $this->scales[1000000] . 's';
            }
            $number %= 1000000;
        }

        // Handle thousands
        if ($number >= 1000) {
            $thousands = (int)($number / 1000);
            if ($thousands === 1) {
                $words[] = $this->scales[1000];
            } else {
                $words[] = $this->convertInteger($thousands) . ' ' . $this->scales[1000];
            }
            $number %= 1000;
        }

        // Handle hundreds
        if ($number >= 100) {
            $hundreds = (int)($number / 100);
            if ($hundreds === 1) {
                $words[] = $this->scales[100];
            } else {
                $words[] = $this->units[$hundreds] . ' ' . $this->scales[100] . 's';
            }
            $number %= 100;
        }

        // Handle tens and units
        if ($number > 0) {
            if ($number < 10) {
                $words[] = $this->units[$number];
            } elseif ($number <= 19) {
                $words[] = $this->teens[$number];
            } else {
                $tens = (int)($number / 10) * 10;
                $units = $number % 10;

                if ($tens === 70) {
                    if ($units === 1) {
                        $words[] = 'soixante et onze';
                    } else {
                        $words[] = 'soixante-' . $this->teens[$units + 10];
                    }
                } elseif ($tens === 90) {
                    $words[] = 'quatre-vingt-' . $this->teens[$units + 10];
                } else {
                    if ($units === 1 && $tens !== 80) {
                        $words[] = $this->tens[$tens] . ' et ' . $this->units[$units];
                    } elseif ($units === 0 && $tens === 80) {
                        $words[] = 'quatre-vingts';
                    } else {
                        $words[] = $this->tens[$tens] . ($units > 0 ? '-' . $this->units[$units] : '');
                    }
                }
            }
        }

        return implode(' ', $words);
    }
}