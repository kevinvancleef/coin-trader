<?php
declare(strict_types = 1);

namespace Coin\Trader\InfraStructure\Bittrex;

use GuzzleHttp\Client as HttpClient;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Noodlehaus\Config;

/**
 * Class BittrexClientProvider
 * @package Coin\Trader\InfraStructure\Bittrex
 */
class BittrexClientProvider extends AbstractServiceProvider
{
    /** @var string[] */
    protected $provides = [
        BittrexClient::class
    ];

    /**
     * @return void
     */
    public function register()
    {
        $container = $this->getContainer();

        $bittrex = $container->get(Config::class)->get('bittrex');

        $container->add(BittrexClient::class, BittrexClient::class)
            ->withArgument(HttpClient::class)
            ->withArgument($bittrex['baseUrl'])
            ->withArgument($bittrex['apiKey'])
            ->withArgument($bittrex['apiSecret']);
    }
}
