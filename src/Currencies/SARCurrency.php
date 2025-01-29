<?php

namespace Abdulbaset\ConvertNumbers\Currencies;

use Abdulbaset\ConvertNumbers\Contracts\Abstracts\CurrencyAbstract;

class SARCurrency extends CurrencyAbstract
{
    public array $translations = [
        'ar' => [
            'singular' => 'ريال سعودي',
            'plural' => 'ريال سعودي',
            'fraction' => 'هللة',
            'currency_symbol' => 'ريال' 
        ],
        'en' => [
            'singular' => 'Saudi Riyal',
            'plural' => 'Saudi Riyals',
            'fraction' => 'halalas',
            'currency_symbol' => 'SAR' 
        ],
        'fr' => [
            'singular' => 'Riyal saoudien',
            'plural' => 'Riyals saoudiens',
            'fraction' => 'Halala',
            'currency_symbol' => 'SR' 
        ],
    ];
}