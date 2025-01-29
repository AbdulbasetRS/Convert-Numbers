<?php

namespace Abdulbaset\ConvertNumbers\Languages;

use Abdulbaset\ConvertNumbers\Contracts\Abstracts\LanguageAbstract;
use Abdulbaset\ConvertNumbers\Utils\NumberFormatter;

class ArabicLanguage extends LanguageAbstract
{
    private $units = [
        0 => 'صفر',
        1 => 'واحد',
        2 => 'اثنان',
        3 => 'ثلاثة',
        4 => 'أربعة',
        5 => 'خمسة',
        6 => 'ستة',
        7 => 'سبعة',
        8 => 'ثمانية',
        9 => 'تسعة',
    ];

    private $teens = [
        10 => 'عشرة',
        11 => 'أحد عشر',
        12 => 'اثنا عشر',
        13 => 'ثلاثة عشر',
        14 => 'أربعة عشر',
        15 => 'خمسة عشر',
        16 => 'ستة عشر',
        17 => 'سبعة عشر',
        18 => 'ثمانية عشر',
        19 => 'تسعة عشر',
    ];

    private $tens = [
        20 => 'عشرون',
        30 => 'ثلاثون',
        40 => 'أربعون',
        50 => 'خمسون',
        60 => 'ستون',
        70 => 'سبعون',
        80 => 'ثمانون',
        90 => 'تسعون',
    ];

    private $hundreds = [
        1 => 'مائة',
        2 => 'مائتان',
        3 => 'ثلاثمائة',
        4 => 'أربعمائة',
        5 => 'خمسمائة',
        6 => 'ستمائة',
        7 => 'سبعمائة',
        8 => 'ثمانمائة',
        9 => 'تسعمائة',
    ];

    private $scales = [
        100 => 'مائة',
        1000 => 'ألف',
        1000000 => 'مليون',
        1000000000 => 'مليار',
    ];

    private array $fileSizeUnits = [
        'بايت',
        'كيلوبايت',
        'ميجابايت',
        'جيجابايت',
        'تيرابايت',
        'بيتابايت'
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
        
        $formattedValue = number_format($value, $decimals, $this->getDecimalPoint(), $this->getThousandsSeparator());
        
        return NumberFormatter::convertToArabicNumerals($formattedValue) . ' ' . ($units[$factor] ?? $units[0]);
    }

    protected function decimalSeparator(): string
    {
        return 'جزءًا من مئة';
    }

    public function connector(): string
    {
        return 'و';
    }

    protected function negativeSign(): string
    {
        return 'سالب';
    }

    protected function language(): string
    {
        return 'ar';
    }

    public function only(): string
    {
        return 'فقط لا غير';
    }
    
    public function convert(int | float $number): string
    {
        if (is_float($number)) {

            $parts = explode('.', number_format($number, 2, '.', ''));
            $integerPart = (int) $parts[0];
            $decimalPart = (float) '0.' . $parts[1];

            $integerString = $this->convertInteger($integerPart);

            $decimalString = $this->convertDecimal($decimalPart);

            return $integerString . ' ' . $this->connector() . ' ' . $decimalString . ' ' . $this->decimalSeparator();
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
            if ($billions === 1) {
                $words[] = $this->scales[1000000000];
            } elseif ($billions === 2) {
                $words[] = 'مليارين';
            } else {
                $words[] = $this->convertInteger($billions) . ' ' . $this->scales[1000000000];
            }
            $number %= 1000000000;
        }

        // Handle millions
        if ($number >= 1000000) {
            $millions = (int) ($number / 1000000);
            if ($millions === 1) {
                $words[] = $this->scales[1000000];
            } elseif ($millions === 2) {
                $words[] = 'مليونين';
            } else {
                $words[] = $this->convertInteger($millions) . ' ' . $this->scales[1000000];
            }
            $number %= 1000000;
        }

        // Handle thousands
        if ($number >= 1000) {
            $thousands = (int) ($number / 1000);
            if ($thousands === 1) {
                $words[] = $this->scales[1000];
            } elseif ($thousands === 2) {
                $words[] = 'ألفين';
            } else {
                $words[] = $this->convertInteger($thousands) . ' ' . $this->scales[1000];
            }
            $number %= 1000;
        }

        // Handle hundreds
        if ($number >= 100) {
            $hundreds = (int) ($number / 100);

            $hundredsMap = $this->hundreds;

            if (isset($hundredsMap[$hundreds])) {
                $words[] = $hundredsMap[$hundreds];
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
                $tens = (int) ($number / 10) * 10;
                $units = $number % 10;
                if ($units > 0) {
                    $words[] = $this->units[$units] . ' ' . $this->connector() . $this->tens[$tens];
                } else {
                    $words[] = $this->tens[$tens];
                }
            }
        }

        $result = '';
        for ($i = 0; $i < count($words); $i++) {
            if ($i === 0) {
                $result = $words[$i];
                continue;
            }

            if ($i === count($words) - 1 && !$this->isScale($words[$i])) {
                $result .= ' ' . $this->connector() . $words[$i];
                continue;
            }

            if ($this->isScale($words[$i - 1]) || $this->containsScale($words[$i - 1])) {
                $result .= ' ' . $this->connector() . $words[$i];
            } else {
                $result .= ' ' . $this->connector() . $words[$i];
            }
        }

        return $result;
    }

    private function isScale(string $word): bool
    {
        return in_array($word, [
            $this->scales[100],
            $this->scales[1000],
            $this->scales[1000000],
            $this->scales[1000000000],
            'مئتان',
            'ألفين',
            'مليونين',
            'مليارين',
        ]);
    }

    private function containsScale(string $word): bool
    {
        return str_contains($word, 'مائة') ||
        str_contains($word, $this->scales[1000]) ||
        str_contains($word, $this->scales[1000000]) ||
        str_contains($word, $this->scales[1000000000]);
    }
}
