<?php

namespace App\Service\Rate\Enums;

enum RateSource: string
{
    case COINBASE = 'coinbase';
    case COINGECKO = 'coingecko';
}
