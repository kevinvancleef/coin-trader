<?php
declare(strict_types = 1);

namespace Coin\Trader\Domain;

/**
 * Class Quantity
 * @package Coin\Trader\Domain
 */
class Quantity
{
    /**
     * @var float
     */
    private $amount;

    /**
     * Quantity constructor.
     * @param float $amount
     */
    public function __construct(float $amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return number_format($this->amount, 8);
    }
}
