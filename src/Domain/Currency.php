<?php
declare(strict_types = 1);

namespace Coin\Trader\Domain;

/**
 * Class Currency
 * @package Coin\Trader\Domain
 */
class Currency
{
    /**
     * @var bool
     */
    private $active;

    /**
     * @var int
     */
    private $minimalConfirmations;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Bitcoin
     */
    private $transactionFee;

    /**
     * Currency constructor.
     * @param string $name
     * @param Bitcoin $transactionFee
     * @param bool $active
     * @param int $minimalConfirmations
     */
    public function __construct(string $name, Bitcoin $transactionFee, bool $active, int $minimalConfirmations)
    {
        $this->name = $name;
        $this->transactionFee = $transactionFee;
        $this->active = $active;
        $this->minimalConfirmations = $minimalConfirmations;
    }

    /**
     * @param array $data
     * @return Currency
     */
    public static function fromArray(array $data): Currency
    {
        $name = $data['CurrencyLong'] . ' (' . $data['Currency'] . ')';

        // TODO: What unit exactly is TxFee.

        return new self($name, new Bitcoin($data['TxFee']), $data['IsActive'], $data['MinConfirmation']);
    }

    /**
     * @return boolean
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @return int
     */
    public function getMinimalConfirmations(): int
    {
        return $this->minimalConfirmations;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Bitcoin
     */
    public function getTransactionFee(): Bitcoin
    {
        return $this->transactionFee;
    }
}
