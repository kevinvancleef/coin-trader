<?php
declare(strict_types = 1);

namespace Coin\Trader\InfraStructure\Bittrex;

use League\Container\ServiceProvider\AbstractServiceProvider;

class BittrexServiceProvider extends AbstractServiceProvider
{
    /** @var string[] */
    protected $provides = [
        BittrexService::class
    ];

    /**
     * @return void
     */
    public function register()
    {
        $container = $this->getContainer();

        $container->add(BittrexService::class, BittrexService::class)
            ->withArgument(BittrexClient::class);
    }
}
