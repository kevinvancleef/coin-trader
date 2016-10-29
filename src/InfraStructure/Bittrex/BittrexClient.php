<?php
declare(strict_types = 1);

namespace Coin\Trader\InfraStructure\Bittrex;

use Coin\Trader\Domain\Bitcoin;
use GuzzleHttp\Client as HttpClient;
use Psr\Http\Message\ResponseInterface;

/**
 * Class BittrexClient
 * @package Coin\Trader\InfraStructure
 */
class BittrexClient
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $apiSecret;

    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * BittrexClient constructor.
     * @param HttpClient $httpClient
     * @param string $baseUrl
     * @param string $apiKey
     * @param string $apiSecret
     */
    public function __construct(HttpClient $httpClient, string $baseUrl, string $apiKey, string $apiSecret)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->baseUrl = $baseUrl;

        $this->httpClient = $httpClient;
    }

    /**
     * @return array
     */
    public function getCurrencies()
    {
        $response = $this->request('GET', '/getcurrencies');

        return json_decode((string)$response->getBody(), true);
    }

    /**
     * @return array
     */
    public function getMarkets(): array
    {
        $response = $this->request('GET', '/getmarkets');

        return json_decode((string)$response->getBody(), true);
    }

    /**
     * @param string $marketShortName
     * @return array
     */
    public function getTicker(string $marketShortName): array
    {
        $response = $this->request('GET', '/getticker', [
            'market' => $marketShortName
        ]);

        return json_decode((string)$response->getBody(), true);
    }

    /**
     * @return array
     */
    public function getMarketSummaries(): array
    {
        $response = $this->request('GET', '/getmarketsummaries');

        return json_decode((string)$response->getBody(), true);
    }

    /**
     * @param string $marketShortName
     * @return array
     */
    public function getMarketSummary(string $marketShortName): array
    {
        $response = $this->request('GET', '/getmarketsummary', [
            'market' => $marketShortName
        ]);

        return json_decode((string)$response->getBody(), true);
    }

    /**
     * @param string $marketShortName
     * @param string $type
     * @return array
     */
    public function getOrderBook(string $marketShortName, string $type = 'both'): array
    {
        $response = $this->request('GET', '/getorderbook', [
            'market' => $marketShortName,
            'type' => $type
        ]);

        return json_decode((string)$response->getBody(), true);
    }

    /**
     * @param string $marketShortName
     * @param int $count Amount of entries to return
     * @return array
     */
    public function getMarketHistory(string $marketShortName, int $count = 50): array
    {
        $response = $this->request('GET', '/getmarkethistory', [
            'market' => $marketShortName,
            'count' => $count
        ]);

        return json_decode((string)$response->getBody(), true);
    }

    public function buyLimit(string $marketShortName, int $quantity, Bitcoin $rate) {

    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $parameters
     * @return ResponseInterface
     */
    private function request(string $method, string $uri, $parameters = []): ResponseInterface
    {
        $parameters = array_merge($parameters, [
            'apikey' => $this->apiKey,
            'nonce' => $this->getNonce()
        ]);

        $url = $this->baseUrl . $uri;
        if (count($parameters)) {
            $url .= '?' . http_build_query($parameters);
        }

        return $this->httpClient->request(
            $method,
            $url,
            [
                'headers' => [
                    'apisign' => $this->getApiSign($uri)
                ]
            ]
        );
    }

    /**
     * @param string $uri
     * @return string
     */
    private function getApiSign(string $uri): string
    {
        return hash_hmac('sha512', $uri, $this->apiSecret);
    }

    /**
     * @return int
     */
    private function getNonce(): int
    {
        return time();
    }
}
