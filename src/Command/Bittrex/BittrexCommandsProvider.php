<?php
declare(strict_types = 1);

namespace Coin\Trader\Command\Bittrex;

use Coin\Trader\InfraStructure\Bittrex\BittrexService;
use League\Container\ServiceProvider\AbstractServiceProvider;

/**
 * Class BittrexCommandsProvider
 * @package Coin\Trader\Command\Bittrex
 */
class BittrexCommandsProvider extends AbstractServiceProvider
{
    /** @var string[] */
    protected $provides = [
        GetCurrenciesCommand::class,
        GetMarketsCommand::class,
        GetMarketSummariesCommand::class,
        GetTickerCommand::class
    ];

    /**
     * @return void
     */
    public function register()
    {
        $container = $this->getContainer();

        $container->add(GetCurrenciesCommand::class, GetCurrenciesCommand::class)
            ->withArgument('currencies')
            ->withArgument(BittrexService::class);

        $container->add(GetMarketsCommand::class, GetMarketsCommand::class)
            ->withArgument('markets')
            ->withArgument(BittrexService::class);

        $container->add(GetMarketSummariesCommand::class, GetMarketSummariesCommand::class)
            ->withArgument('market-summaries')
            ->withArgument(BittrexService::class);

        $container->add(GetTickerCommand::class, GetTickerCommand::class)
            ->withArgument('ticker')
            ->withArgument(BittrexService::class);
    }
}
