<?php
declare(strict_types = 1);

namespace Coin\Trader\Domain;

/**
 * Class Order
 * @package Coin\Trader\Domain
 */
class Order
{
    /** @var float */
    private $quantity;

    /** @var Bitcoin */
    private $rate;

    /**
     * Order constructor.
     * @param float $quantity
     * @param Bitcoin $rate
     */
    public function __construct(float $quantity, Bitcoin $rate)
    {
        $this->quantity = $quantity;
        $this->rate = $rate;
    }

    /**
     * @return float
     */
    public function getQuantity(): float
    {
        return $this->quantity;
    }

    /**
     * @return Bitcoin
     */
    public function getRate(): Bitcoin
    {
        return $this->rate;
    }
}
