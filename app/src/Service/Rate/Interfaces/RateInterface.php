<?php

namespace App\Service\Rate\Interfaces;

use App\Service\Rate\ValueObjects\RateResponse;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

interface RateInterface
{
    /**
     * @throws TransportExceptionInterface
     * @return RateResponse
     */
    public function getPrice(): RateResponse;
}