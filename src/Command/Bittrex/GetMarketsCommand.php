<?php
declare(strict_types = 1);

namespace Coin\Trader\Command\Bittrex;

use Coin\Trader\Domain\Market;
use Coin\Trader\InfraStructure\Bittrex\BittrexService;
use GuzzleHttp\Exception\ConnectException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class GetMarketsCommand
 * @package Coin\Trader\Command
 */
class GetMarketsCommand extends Command
{
    /**
     * @var BittrexService
     */
    private $bittrexService;

    /**
     * GetMarketsCommand constructor.
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
            ->setName('markets')
            ->setDescription('Get the open and available trading markets at Bittrex along with other meta data.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $markets = $this->bittrexService->getMarkets();
        } catch (ConnectException $exception) {
            $io->error('Not able to connect to bittrex.com. Do you have an internet connection?');
            exit;
        }

        $tableRows = array();

        /** @var Market $market */
        foreach ($markets as $market) {
            $notice = empty($market->getNotice()) ? '' : substr($market->getNotice(), 0, 70) . '...';

            $tableRows[] = [
                $market->getName(),
                $market->getCurrency(),
                $market->getMinimumTradeSizeInBtc()->__toString(),
                $market->getDateCreated()->format('d-m-Y'),
                $market->isActive() ? 'Yes' : 'No',
                $notice
            ];
        }

        $io->title('Markets');
        $io->table(
            array('Market', 'Currency', 'Min. Trade Size (BTC)', 'Date Created', 'Active', 'Notice'),
            $tableRows
        );

        $output->writeln('');
    }
}
