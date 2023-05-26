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

class CoinGeckoRate implements RateInterface
{
    protected string $url;
    protected string $usefullBase;

    public function __construct(
        protected BaseCurrency        $base,
        protected QuoteCurrency       $quote,
        protected HttpClientInterface $client
    )
    {
        $this->usefullBase = match ($this->base) {
            BaseCurrency::BTC => 'bitcoin',
            default => throw new \InvalidArgumentException(
                "Unexpected match value \"{$this->base->value}\""
            )
        };
        $this->url = "https://api.coingecko.com/api/v3/simple/price";
    }

    /**
     * @throws HttpExceptionInterface|TransportExceptionInterface
     */
    public function getPrice(): RateResponse
    {
        $response = $this->client->request('GET', $this->url, [
            'query' => [
                'ids' => $this->usefullBase,
                'vs_currencies' => $this->quote->value
            ]
        ]);
        $data = json_decode($response->getContent());
        return new RateResponse(
            $this->base->value,
            $this->quote->value,
            RateSource::COINGECKO->value,
            (float)$data->{$this->usefullBase}->{$this->quote->value}
        );
    }
}