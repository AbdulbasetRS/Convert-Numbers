<?php

namespace Abdulbaset\ConvertNumbers;

use Abdulbaset\ConvertNumbers\Currencies\EGPCurrency;
use Abdulbaset\ConvertNumbers\Currencies\EURCurrency;
use Abdulbaset\ConvertNumbers\Currencies\SARCurrency;
use Abdulbaset\ConvertNumbers\Currencies\USDCurrency;
use Abdulbaset\ConvertNumbers\Exceptions\UnsupportedCurrencyException;
use Abdulbaset\ConvertNumbers\Exceptions\UnsupportedLanguageException;
use Abdulbaset\ConvertNumbers\Languages\ArabicLanguage;
use Abdulbaset\ConvertNumbers\Languages\EnglishLanguage;
use Abdulbaset\ConvertNumbers\Languages\FrenchLanguage;
use Abdulbaset\ConvertNumbers\Utils\NumberFormatter;

class ConvertNumbers
{
    private static array $currencyConverters = [
        'USD' => USDCurrency::class,
        'EGP' => EGPCurrency::class,
        'SAR' => SARCurrency::class,
        'EUR' => EURCurrency::class,
    ];

    private static array $languageConverters = [
        'en' => EnglishLanguage::class,
        'ar' => ArabicLanguage::class,
        'fr' => FrenchLanguage::class,
    ];

    public static function toWords(int | float $number, string $language = 'en'): string
    {
        $converterClass = self::$languageConverters[$language] ?? throw new UnsupportedLanguageException($language);
        $converter = new $converterClass();

        return $converter->convert($number);
    }

    public static function currencyToWords(float $amount, string $currency = 'USD', string $language = 'en'): string
    {
        if (!isset(self::$currencyConverters[$currency])) {
            throw new UnsupportedCurrencyException($currency);
        }

        if (!isset(self::$languageConverters[$language])) {
            throw new UnsupportedLanguageException($language);
        }

        $currencyClass = self::$currencyConverters[$currency];
        $currencyInstance = new $currencyClass();

        $languageClass = self::$languageConverters[$language];
        $languageInstance = new $languageClass();

        $parts = explode('.', number_format($amount, 2, '.', ''));
        $integerPart = (int) $parts[0];
        $decimalPart = (int) $parts[1];

        $translations = $currencyInstance->translations[$language] ?? $currencyInstance->translations['en'];

        $integerWords = $languageInstance->convert($integerPart);

        $decimalWords = $languageInstance->convert($decimalPart);

        $currencyName = $integerPart === 1 ? $translations['singular'] : $translations['plural'];
        $fractionName = $decimalPart === 1 ? $translations['fraction'] : $translations['fraction'];

        $result = $integerWords . ' ' . $currencyName;

        $decimalPart ? $result .= ' ' . $languageInstance->connector() . ' ' . $decimalWords . ' ' . $fractionName : '';
        
        $result .= ' ' . $languageInstance->only();

        return $result;
    }

    public static function currencyFormat(float $amount, string $currency = 'USD', string $language = 'en', bool $symbol = false): string
    {
        if (!isset(self::$currencyConverters[$currency])) {
            throw new UnsupportedCurrencyException($currency);
        }

        if (!isset(self::$languageConverters[$language])) {
            throw new UnsupportedLanguageException($language);
        }

        $currencyClass = self::$currencyConverters[$currency];
        $currencyInstance = new $currencyClass();

        $languageClass = self::$languageConverters[$language];
        $languageInstance = new $languageClass();

        $formattedNumber = NumberFormatter::formatWithSeparators(
            $amount,
            $languageInstance->getDecimalPoint(),
            $languageInstance->getThousandsSeparator()
        );

        if ($language === 'ar') {
            $formattedNumber = NumberFormatter::convertToArabicNumerals($formattedNumber);
        }

        if (!$symbol) {
            return $formattedNumber;
        }

        $translations = $currencyInstance->translations[$language] ?? $currencyInstance->translations['en'];
        $currencySymbol = $translations['currency_symbol'];

        // return ($language === 'ar' && in_array($currency, ['EGP', 'SAR']))
        // ? $formattedNumber . ' ' . $currencySymbol
        // : $currencySymbol . ' ' . $formattedNumber;

        return $formattedNumber . ' ' . $currencySymbol;
    }

    public static function toArabicNumerals(string $number): string
    {
        return NumberFormatter::convertToArabicNumerals($number);
    }

    public static function toFileSize(float $bytes, string $language = 'en', int $decimals = 2): string
    {
        if (!isset(self::$languageConverters[$language])) {
            throw new UnsupportedLanguageException($language);
        }

        $languageClass = self::$languageConverters[$language];
        $languageInstance = new $languageClass();

        return $languageInstance->formatFileSize($bytes, $decimals);
    }
}
