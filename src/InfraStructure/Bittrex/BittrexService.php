<?php
declare(strict_types = 1);

namespace Coin\Trader\InfraStructure\Bittrex;

use Coin\Trader\Domain\Bitcoin;
use Coin\Trader\Domain\Currency;
use Coin\Trader\Domain\Market;
use Coin\Trader\Domain\MarketSummary;
use Coin\Trader\Domain\OrderBook;

/**
 * Class BittrexService
 * @package Coin\Trader\InfraStructure\Bittrex
 */
class BittrexService
{
    const ORDER_BOOK_TYPE_SELL = 'sell';
    const ORDER_BOOK_TYPE_BUY = 'buy';
    const ORDER_BOOK_TYPE_BUY_AND_SELL = 'both';

    /**
     * @var BittrexClient
     */
    private $client;

    /**
     * BittrexService constructor.
     * @param BittrexClient $client
     */
    public function __construct(BittrexClient $client)
    {
        $this->client = $client;
    }

    /**
     * @return array
     */
    public function getCurrencies(): array
    {
        $currencies = [];

        $response = $this->client->getCurrencies();

        foreach ($response['result'] as $currency) {
            $currencies[] = Currency::fromArray($currency);
        }

        return $currencies;
    }

    /**
     * @return array
     */
    public function getMarkets(): array
    {
        $markets = [];

        $response = $this->client->getMarkets();

        foreach ($response['result'] as $market) {
            $markets[] = Market::fromArray($market);
        }

        return $markets;
    }

    /**
     * @return array
     */
    public function getMarketSummaries(): array
    {
        $summaries = [];

        $response = $this->client->getMarketSummaries();

        foreach ($response['result'] as $summary) {
            $summaries[] = MarketSummary::fromArray($summary);
        }

        return $summaries;
    }

    /**
     * @param string $marketShortName
     * @return MarketSummary
     */
    public function getMarketSummary(string $marketShortName): MarketSummary
    {
        $response = $this->client->getMarketSummary($marketShortName);

        return MarketSummary::fromArray($response['result'][0]);
    }

    /**
     * @param string $marketShortName
     * @param string $type
     * @return OrderBook
     */
    public function getOrderBook(string $marketShortName, $type = self::ORDER_BOOK_TYPE_BUY_AND_SELL): OrderBook
    {
        $response = $this->client->getOrderBook($marketShortName, $type);

        return OrderBook::fromArray($response['result']);
    }

    /**
     * @param string $marketShortName
     * @return array
     */
    public function getTicker(string $marketShortName): array
    {
        $response = $this->client->getTicker($marketShortName);

        return [
            'bid' => new Bitcoin($response['result']['Bid']),
            'ask' => new Bitcoin($response['result']['Ask']),
            'last' => new Bitcoin($response['result']['Last'])
        ];
    }
}
