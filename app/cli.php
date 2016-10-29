<?php
require __DIR__.'/bootstrap.php';

use Coin\Trader\Command\Bittrex\BittrexCommandsProvider;
use Coin\Trader\Command\Bittrex\GetCurrenciesCommand;
use Coin\Trader\Command\Bittrex\GetMarketsCommand;
use Coin\Trader\Command\Bittrex\GetMarketSummariesCommand;
use Coin\Trader\Command\Bittrex\GetOrderBookCommand;
use Coin\Trader\Command\Bittrex\GetTickerCommand;
use Coin\Trader\InfraStructure\Bittrex\BittrexClientProvider;
use Coin\Trader\InfraStructure\Bittrex\BittrexServiceProvider;
use Coin\Trader\InfraStructure\ConfigurationServiceProvider;
use Coin\Trader\InfraStructure\GuzzleClientProvider;
use League\Container\Container;
use Symfony\Component\Console\Application;

$container = new Container();
$container->addServiceProvider(BittrexClientProvider::class);
$container->addServiceProvider(BittrexServiceProvider::class);
$container->addServiceProvider(BittrexCommandsProvider::class);
$container->addServiceProvider(ConfigurationServiceProvider::class);
$container->addServiceProvider(GuzzleClientProvider::class);

$application = new Application('Coin Trader', '0.1.0');

$application->add($container->get(GetCurrenciesCommand::class));
$application->add($container->get(GetMarketsCommand::class));
$application->add($container->get(GetMarketSummariesCommand::class));
$application->add($container->get(GetTickerCommand::class));
$application->add($container->get(GetOrderBookCommand::class));

$application->run();
