<?php
declare(strict_types = 1);

namespace Coin\Trader\Command\Bittrex;

use Coin\Trader\Domain\Currency;
use Coin\Trader\InfraStructure\Bittrex\BittrexService;
use GuzzleHttp\Exception\ConnectException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class GetCurrenciesCommand
 * @package Coin\Trader\Command
 */
class GetCurrenciesCommand extends Command
{
    /**
     * @var BittrexService
     */
    private $bittrexService;

    /**
     * GetCurrenciesCommand constructor.
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
            ->setName('currencies')
            ->setDescription('Get all supported currencies at Bittrex along with other meta data.');
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
            $currencies = $this->bittrexService->getCurrencies();
        } catch (ConnectException $exception) {
            $io->error('Not able to connect to bittrex.com. Do you have an internet connection?');
            exit;
        }

        $tableRows = array();

        /** @var Currency $currency */
        foreach ($currencies as $currency) {
            $tableRows[] = [
                $currency->getName(),
                $currency->getTransactionFee()->__toString(),
                $currency->getMinimalConfirmations(),
                $currency->isActive() ? 'Yes' : 'No'
            ];
        }

        $io->title('Currencies');
        $io->table(
            array('Name', 'Transaction Fee (BTC)', 'Min. Confirmations', 'Active'),
            $tableRows
        );

        $output->writeln('');
    }
}
