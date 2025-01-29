<?php

namespace Abdulbaset\ConvertNumbers\Currencies;

use Abdulbaset\ConvertNumbers\Contracts\Abstracts\CurrencyAbstract;

class EURCurrency extends CurrencyAbstract
{
    public array $translations = [
        'ar' => [
            'singular' => 'يورو',
            'plural' => 'يورو',
            'fraction' => 'سنت',
            'currency_symbol' => '€'
        ],
        'en' => [
            'singular' => 'euro',
            'plural' => 'euros',
            'fraction' => 'cents',
            'currency_symbol' => '€'
        ],
        'fr' => [
            'singular' => 'Euro',
            'plural' => 'Euros',
            'fraction' => 'Centime',
            'currency_symbol' => '€'
        ],
    ];
}