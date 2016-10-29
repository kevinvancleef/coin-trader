<?php
declare(strict_types = 1);

namespace Coin\Trader\InfraStructure;

use GuzzleHttp\Client;
use League\Container\ServiceProvider\AbstractServiceProvider;

/**
 * Class GuzzleClientProvider
 * @package Coin\Trader\InfraStructure
 */
class GuzzleClientProvider extends AbstractServiceProvider
{
    /** @var string[] */
    protected $provides = [
        Client::class
    ];

    /**
     * @return void
     */
    public function register()
    {
        $container = $this->getContainer();

        $container->add(Client::class, Client::class);
    }
}
