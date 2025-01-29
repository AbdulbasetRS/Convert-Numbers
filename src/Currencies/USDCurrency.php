<?php

namespace Abdulbaset\ConvertNumbers\Currencies;

use Abdulbaset\ConvertNumbers\Contracts\Abstracts\CurrencyAbstract;

class USDCurrency extends CurrencyAbstract
{
    public array $translations = [
        'ar' => [
            'singular' => 'دولار',
            'plural' => 'دولارًا', 
            'fraction' => 'سنت',
            'currency_symbol' => '$' 
        ],
        'en' => [
            'singular' => 'dollar',
            'plural' => 'dollars',
            'fraction' => 'cents',
            'currency_symbol' => '$'
        ],
        'fr' => [
            'singular' => 'Dollar américain',
            'plural' => 'Dollars américains',
            'fraction' => 'Cent',
            'currency_symbol' => '$'
        ],
    ];
}