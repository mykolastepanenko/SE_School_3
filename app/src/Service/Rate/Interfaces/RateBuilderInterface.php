<?php

namespace App\Service\Rate\Interfaces;

interface RateBuilderInterface
{
    public function reset(/*string $rateSource*/); //TODO перевір чи потрібен цей метод згідно патерна
    public function setSource(string $source): void;
    public function setBaseCurrency(string $baseCurrency): void;
    public function setQuoteCurrency(string $quoteCurrency): void;
    public function getBuilder(): object;
}