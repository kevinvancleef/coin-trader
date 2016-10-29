<?php
declare(strict_types = 1);

namespace Coin\Trader\Domain;

/**
 * Class MarketSummary
 * @package Coin\Trader\Domain
 */
class MarketSummary
{
    /** @var int */
    private $amountOfOpenBuyOrders = -1;

    /** @var int */
    private $amountOfOpenSellOrders = -1;

    /** @var Bitcoin */
    private $ask;

    /** @var Bitcoin */
    private $baseVolume;

    /** @var Bitcoin */
    private $bid;

    /** @var \DateTime */
    private $dateMarketCreated;

    /** @var Bitcoin */
    private $high;

    /** @var Bitcoin */
    private $last;

    /** @var \DateTime */
    private $lastUpdateDateTime;

    /** @var Bitcoin */
    private $low;

    /** @var string */
    private $marketName = '';

    /** @var Bitcoin */
    private $previousDay;

    /** @var Bitcoin */
    private $volume;

    /**
     * MarketSummary constructor.
     * @param int $amountOfOpenBuyOrders
     * @param int $amountOfOpenSellOrders
     * @param Bitcoin $ask
     * @param Bitcoin $baseVolume
     * @param Bitcoin $bid
     * @param \DateTime $dateMarketCreated
     * @param Bitcoin $high
     * @param Bitcoin $last
     * @param \DateTime $lastUpdateDateTime
     * @param Bitcoin $low
     * @param string $marketName
     * @param Bitcoin $previousDay
     * @param Bitcoin $volume
     */
    public function __construct(
        int $amountOfOpenBuyOrders,
        int $amountOfOpenSellOrders,
        Bitcoin $ask,
        Bitcoin $baseVolume,
        Bitcoin $bid,
        \DateTime $dateMarketCreated,
        Bitcoin $high,
        Bitcoin $last,
        \DateTime $lastUpdateDateTime,
        Bitcoin $low,
        string $marketName,
        Bitcoin $previousDay,
        Bitcoin $volume
    ) {
        $this->amountOfOpenBuyOrders = $amountOfOpenBuyOrders;
        $this->amountOfOpenSellOrders = $amountOfOpenSellOrders;
        $this->ask = $ask;
        $this->baseVolume = $baseVolume;
        $this->bid = $bid;
        $this->dateMarketCreated = $dateMarketCreated;
        $this->high = $high;
        $this->last = $last;
        $this->lastUpdateDateTime = $lastUpdateDateTime;
        $this->low = $low;
        $this->marketName = $marketName;
        $this->previousDay = $previousDay;
        $this->volume = $volume;
    }

    public static function fromArray(array $data)
    {
        $dateMarketCreated = new \DateTime();
        $dateMarketCreated->setTimestamp(strtotime($data['Created']));

        $lastUpdateDateTime = new \DateTime();
        $lastUpdateDateTime->setTimestamp(strtotime($data['TimeStamp']));

        return new self(
            $data['OpenBuyOrders'],
            $data['OpenSellOrders'],
            new Bitcoin($data['Ask']),
            new Bitcoin($data['BaseVolume']),
            new Bitcoin($data['Bid']),
            $dateMarketCreated,
            new Bitcoin($data['High']),
            new Bitcoin($data['Last']),
            $lastUpdateDateTime,
            new Bitcoin($data['Low']),
            $data['MarketName'],
            new Bitcoin($data['PrevDay']),
            new Bitcoin($data['Volume'])
        );
    }

    /**
     * @return int
     */
    public function getAmountOfOpenBuyOrders(): int
    {
        return $this->amountOfOpenBuyOrders;
    }

    /**
     * @return int
     */
    public function getAmountOfOpenSellOrders(): int
    {
        return $this->amountOfOpenSellOrders;
    }

    /**
     * @return Bitcoin
     */
    public function getAsk(): Bitcoin
    {
        return $this->ask;
    }

    /**
     * @return Bitcoin
     */
    public function getBaseVolume(): Bitcoin
    {
        return $this->baseVolume;
    }

    /**
     * @return Bitcoin
     */
    public function getBid(): Bitcoin
    {
        return $this->bid;
    }

    /**
     * @return \DateTime
     */
    public function getDateMarketCreated(): \DateTime
    {
        return $this->dateMarketCreated;
    }

    /**
     * @return Bitcoin
     */
    public function getHigh(): Bitcoin
    {
        return $this->high;
    }

    /**
     * @return Bitcoin
     */
    public function getLast(): Bitcoin
    {
        return $this->last;
    }

    /**
     * @return \DateTime
     */
    public function getLastUpdateDateTime(): \DateTime
    {
        return $this->lastUpdateDateTime;
    }

    /**
     * @return Bitcoin
     */
    public function getLow(): Bitcoin
    {
        return $this->low;
    }

    /**
     * @return string
     */
    public function getMarketName(): string
    {
        return $this->marketName;
    }

    /**
     * @return Bitcoin
     */
    public function getPreviousDay(): Bitcoin
    {
        return $this->previousDay;
    }

    /**
     * @return Bitcoin
     */
    public function getVolume(): Bitcoin
    {
        return $this->volume;
    }
}
