<?php
declare(strict_types = 1);

namespace Coin\Trader\Domain;

/**
 * Class Market
 * @package Coin\Trader\Domain
 */
class Market
{
    /** @var bool */
    private $active = false;

    /** @var string */
    private $currency = '';

    /** @var \DateTime */
    private $dateCreated;

    /** @var float */
    private $minimumTradeSizeInBtc = 0.00000000;

    /** @var string */
    private $name = '';

    /** @var string */
    private $notice = '';

    /**
     * Market constructor.
     * @param string $name
     * @param string $currency
     * @param \DateTime $dateCreated
     * @param bool $active
     * @param string $notice
     * @param Bitcoin $minimumTradeSizeInBtc
     */
    public function __construct(
        string $name,
        string $currency,
        \DateTime $dateCreated,
        bool $active,
        string $notice,
        Bitcoin $minimumTradeSizeInBtc
    ) {
        $this->name = $name;
        $this->currency = $currency;
        $this->dateCreated = $dateCreated;
        $this->active = $active;
        $this->notice = $notice;
        $this->minimumTradeSizeInBtc = $minimumTradeSizeInBtc;
    }

    /**
     * @param array $data
     * @return Market
     */
    public static function fromArray(array $data): Market
    {
        $currency = $data['MarketCurrencyLong'] . ' (' . $data['MarketCurrency'] . ')';

        $dateCreated = new \DateTime();
        $dateCreated->setTimestamp(strtotime($data['Created']));

        $notice = (string)(array_key_exists('Notice', $data) ? $data['Notice'] : '');

        return new self(
            $data['MarketName'],
            $currency,
            $dateCreated,
            $data['IsActive'],
            $notice,
            new Bitcoin($data['MinTradeSize'])
        );
    }

    /**
     * @return boolean
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreated(): \DateTime
    {
        return $this->dateCreated;
    }

    /**
     * @return Bitcoin
     */
    public function getMinimumTradeSizeInBtc(): Bitcoin
    {
        return $this->minimumTradeSizeInBtc;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getNotice(): string
    {
        return $this->notice;
    }
}
