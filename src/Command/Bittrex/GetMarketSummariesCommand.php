<?php
declare(strict_types = 1);

namespace Coin\Trader\Command\Bittrex;

use Coin\Trader\Domain\MarketSummary;
use Coin\Trader\InfraStructure\Bittrex\BittrexService;
use GuzzleHttp\Exception\ConnectException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class GetMarketSummariesCommand
 * @package Coin\Trader\Command
 */
class GetMarketSummariesCommand extends Command
{
    /**
     * @var BittrexService
     */
    private $bittrexService;

    /**
     * GetMarketSummariesCommand constructor.
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
            ->setName('market-summaries')
            ->setDescription('Get the last 24 hour summary of all active exchanges.')
            ->setDefinition(
                new InputDefinition(array(
                    new InputOption('market', 'm', InputOption::VALUE_OPTIONAL),
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

        try {
            if ($input->hasOption('market')) {
                $marketSummaries = [$this->bittrexService->getMarketSummary($input->getOption('market'))];
            } else {
                $marketSummaries = $this->bittrexService->getMarketSummaries();
            }
        } catch (ConnectException $exception) {
            $io->error('Not able to connect to bittrex.com. Do you have an internet connection?');
            exit;
        }

        $tableRows = array();

        /** @var MarketSummary $marketSummary */
        foreach ($marketSummaries as $marketSummary) {
            $tableRows[] = [
                $marketSummary->getMarketName()
            ];
        }

        $io->title('Market summaries');
        $io->table(
            array(
                'Market'
            ),
            $tableRows
        );

        $output->writeln('');
    }
}
