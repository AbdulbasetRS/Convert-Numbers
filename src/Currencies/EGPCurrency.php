<?php

namespace Abdulbaset\ConvertNumbers\Currencies;

use Abdulbaset\ConvertNumbers\Contracts\Abstracts\CurrencyAbstract;

class EGPCurrency extends CurrencyAbstract
{
    public array $translations = [
        'ar' => [
            'singular' => 'جنيه مصري',
            'plural' => 'جنيه مصري',
            'fraction' => 'قرش',
            'currency_symbol' => 'ج.م'
        ],
        'en' => [
            'singular' => 'Egyptian Pound',
            'plural' => 'Egyptian Pounds',
            'fraction' => 'piastre',
            'currency_symbol' => 'EGP'
        ],
        'fr' => [
            'singular' => 'Livre égyptienne',
            'plural' => 'Livres égyptiennes',
            'fraction' => 'Piastre',
            'currency_symbol' => 'LE'
        ],
    ];
}