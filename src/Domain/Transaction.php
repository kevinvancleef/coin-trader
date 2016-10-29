<?php
declare(strict_types = 1);

namespace Coin\Trader\Domain;

/**
 * Class Transaction
 * @package Coin\Trader\Domain
 */
class Transaction
{
    /** @var \DateTime */
    private $date;

    /** @var string */
    private $fillType;

    /** @var string */
    private $orderType;

    /** @var Quantity */
    private $quantity;

    /** @var Bitcoin */
    private $rate;

    /** @var int */
    private $transactionId;

    /** @var Bitcoin */
    private $transactionValue;

    /**
     * Transaction constructor.
     * @param int $transactionId
     * @param \DateTime $date
     * @param Quantity $quantity
     * @param Bitcoin $rate
     * @param Bitcoin $transactionValue
     * @param string $fillType
     * @param string $orderType
     */
    public function __construct(
        $transactionId,
        \DateTime $date,
        Quantity $quantity,
        Bitcoin $rate,
        Bitcoin $transactionValue,
        $fillType,
        $orderType
    ) {
        $this->transactionId = $transactionId;
        $this->date = $date;
        $this->quantity = $quantity;
        $this->rate = $rate;
        $this->transactionValue = $transactionValue;
        $this->fillType = $fillType;
        $this->orderType = $orderType;
    }

    /**
     * @param array $data
     * @return Transaction
     */
    public static function fromArray(array $data): Transaction
    {
        $date = new \DateTime();
        $date->setTimestamp(strtotime($data['TimeStamp']));

        return new Transaction(
            $data['Id'],
            $date,
            new Quantity($data['Quantity']),
            new Bitcoin($data['Price']),
            new Bitcoin($data['Total']),
            $data['FillType'],
            $data['OrderType']
        );
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getFillType(): string
    {
        return $this->fillType;
    }

    /**
     * @return string
     */
    public function getOrderType(): string
    {
        return $this->orderType;
    }

    /**
     * @return Quantity
     */
    public function getQuantity(): Quantity
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

    /**
     * @return int
     */
    public function getTransactionId(): int
    {
        return $this->transactionId;
    }

    /**
     * @return Bitcoin
     */
    public function getTransactionValue(): Bitcoin
    {
        return $this->transactionValue;
    }
}
