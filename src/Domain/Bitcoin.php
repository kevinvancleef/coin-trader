<?php
declare(strict_types = 1);

namespace Coin\Trader\Domain;

/**
 * Class Bitcoin
 * @package Coin\Trader\Domain
 */
class Bitcoin
{
    /**
     * @var float
     */
    private $amount;

    /**
     * Bitcoin constructor.
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
