<?php
declare(strict_types = 1);

namespace Coin\Trader\Command\Bittrex;

use Coin\Trader\Domain\Order;
use Coin\Trader\InfraStructure\Bittrex\BittrexService;
use GuzzleHttp\Exception\ConnectException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GetOrderBookCommand extends Command
{
    /**
     * @var BittrexService
     */
    private $bittrexService;

    /**
     * GetTickerCommand constructor.
     * @param null|string $name
     * @param BittrexService $bittrexService
     */
    public function __construct($name, BittrexService $bittrexService)
    {
        parent::__construct($name);

        $this->bittrexService = $bittrexService;
    }

    protected function configure()
    {
        $this
            ->setName('order-book')
            ->setDescription('Retrieve the order book for a given market.')
            ->setDefinition(
                new InputDefinition(array(
                    new InputOption('market', 'm', InputOption::VALUE_REQUIRED),
                ))
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $market = $input->getOption('market');
        if (empty($market)) {
            $market = $io->ask('For which market do you want to see the order book? (e.g. BTC-NLG)');
        }

        try {
            $orderBook = $this->bittrexService->getOrderBook($market);
        } catch (ConnectException $exception) {
            $io->error('Not able to connect to bittrex.com. Do you have an internet connection?');
            exit;
        }

        $buyOrders = $orderBook->getBuyOrders();
        $buyOrderRows = [];
        /** @var Order $order */
        foreach ($buyOrders as $order) {
            $buyOrderRows[] = [
                $order->getQuantity(),
                $order->getRate()->__toString(),
            ];
        }

        $io->section('Buy Order Book: ' . $market . ' (' . date('d-m-Y H:i:s') . ')');
        $io->table(
            ['Quantity', 'Rate (BTC)'],
            $buyOrderRows
        );

        $sellOrders = $orderBook->getSellOrders();
        $sellOrderRows = [];
        /** @var Order $order */
        foreach ($sellOrders as $order) {
            $sellOrderRows[] = [
                $order->getQuantity(),
                $order->getRate()->__toString(),
            ];
        }

        $io->section('Sell Order Book: ' . $market . ' (' . date('d-m-Y H:i:s') . ')');
        $io->table(
            ['Quantity', 'Rate (BTC)'],
            $sellOrderRows
        );

        $output->writeln('');
    }
}
