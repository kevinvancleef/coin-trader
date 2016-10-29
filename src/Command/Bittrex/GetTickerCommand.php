<?php
declare(strict_types = 1);

namespace Coin\Trader\Command\Bittrex;

use Coin\Trader\InfraStructure\Bittrex\BittrexService;
use GuzzleHttp\Exception\ConnectException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class GetTickerCommand
 * @package Coin\Trader\Command
 */
class GetTickerCommand extends Command
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
            ->setName('ticker')
            ->setDescription('Get the current tick values for a market.')
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

        try {
            $ticker = $this->bittrexService->getTicker($market);
        } catch (ConnectException $exception) {
            $io->error('Not able to connect to bittrex.com. Do you have an internet connection?');
            exit;
        }

        $io->title('Market: ' . $market . ' (' . date('d-m-Y H:i:s') . ')');
        $io->table(
            ['Bid (BTC)', 'Ask (BTC)', 'Last (BTC)'],
            [
                [$ticker['bid'], $ticker['ask'], $ticker['last']]
            ]
        );

        $output->writeln('');
    }
}
