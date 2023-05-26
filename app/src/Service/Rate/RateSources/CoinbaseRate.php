<?php

namespace App\Service\Rate\RateSources;

use App\Service\Rate\Enums\BaseCurrency;
use App\Service\Rate\Enums\QuoteCurrency;
use App\Service\Rate\Enums\RateSource;
use App\Service\Rate\Interfaces\RateInterface;
use App\Service\Rate\ValueObjects\RateResponse;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CoinbaseRate implements RateInterface
{
    protected string $url;

    public function __construct(
        protected BaseCurrency        $base,
        protected QuoteCurrency       $quote,
        protected HttpClientInterface $client
    )
    {
        $this->url = "https://api.coinbase.com/v2/prices/{$this->base->value}-{$this->quote->value}/spot";
    }

    /**
     * @throws HttpExceptionInterface|TransportExceptionInterface
     */
    public function getPrice(): RateResponse
    {
        $response = $this->client->request('GET', $this->url);
        $data = json_decode($response->getContent());
        return new RateResponse(
            $this->base->value,
            $this->quote->value,
            RateSource::COINBASE->value,
            $data->data->amount
        );
    }
}