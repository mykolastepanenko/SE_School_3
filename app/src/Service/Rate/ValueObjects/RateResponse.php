<?php

namespace App\Service\Rate\ValueObjects;

class RateResponse
{
    public function __construct(
        public string $base,
        public string $quote,
        public string $source,
        public float $price,
    )
    {
    }
}