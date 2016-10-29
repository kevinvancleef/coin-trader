<?php
declare(strict_types = 1);

namespace Coin\Trader\Domain;

/**
 * Class OrderBook
 * @package Coin\Trader\Domain
 */
class OrderBook
{
    /** @var array */
    private $buyOrders = [];

    /** @var array */
    private $sellOrders = [];

    /**
     * OrderBook constructor.
     * @param array $buyOrders
     * @param array $sellOrders
     */
    public function __construct(array $buyOrders, array $sellOrders)
    {
        $this->buyOrders = $buyOrders;
        $this->sellOrders = $sellOrders;
    }

    public static function fromArray(array $data)
    {
        $buyOrders = [];
        foreach ($data['buy'] as $order) {
            $buyOrders[] = new Order($order['Quantity'], new Bitcoin($order['Rate']));
        }

        $sellOrders = [];
        foreach ($data['sell'] as $order) {
            $sellOrders[] = new Order($order['Quantity'], new Bitcoin($order['Rate']));
        }

        return new OrderBook($buyOrders, $sellOrders);
    }

    /**
     * @return array
     */
    public function getBuyOrders(): array
    {
        return $this->buyOrders;
    }

    /**
     * @return array
     */
    public function getSellOrders(): array
    {
        return $this->sellOrders;
    }
}
