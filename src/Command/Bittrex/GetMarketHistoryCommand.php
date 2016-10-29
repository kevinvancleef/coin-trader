<?php
declare(strict_types = 1);

namespace Coin\Trader\Command\Bittrex;

use Coin\Trader\Domain\Transaction;
use Coin\Trader\InfraStructure\Bittrex\BittrexService;
use GuzzleHttp\Exception\ConnectException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class GetMarketHistoryCommand
 * @package Coin\Trader\Command\Bittrex
 */
class GetMarketHistoryCommand extends Command
{
    /**
     * @var BittrexService
     */
    private $bittrexService;

    /**
     * GetMarketHistoryCommand constructor.
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
            ->setName('market-history')
            ->setDescription('Retrieve the latest trades that have occurred for a specific market.')
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
            $market = $io->ask('For which market do you want to see the market history? (e.g. BTC-NLG)');
        }

        try {
            $transactions = $this->bittrexService->getMarketHistory($market);
        } catch (ConnectException $exception) {
            $io->error('Not able to connect to bittrex.com. Do you have an internet connection?');
            exit;
        }

        $transactionRows = [];
        /** @var Transaction $transaction */
        foreach ($transactions as $transaction) {
            $transactionRows[] = [
                $transaction->getTransactionId(),
                $transaction->getDate()->format('d-m-Y H:i:s'),
                str_pad($transaction->getQuantity()->__toString(), 15, ' ', STR_PAD_LEFT),
                $transaction->getRate()->__toString(),
                $transaction->getTransactionValue()->__toString(),
                $transaction->getFillType(),
                $transaction->getOrderType()
            ];
        }

        $io->title('Market History: ' . $market . ' (' . date('d-m-Y H:i:s') . ')');
        $io->table(
            ['Transaction Id', 'Date', 'Quantity', 'Rate (BTC)', 'Total (BTC)', 'Fill Type', 'Buy/Sell'],
            $transactionRows
        );

        $output->writeln('');
    }
}
